<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Models\Kontingen;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PersonController extends Controller
{
    public function index()
    {
        return PersonResource::collection(Person::with('probability')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullName' => 'required|string|max:40',
            'birthdate' => 'required|date|before:today',
            'identityNumber' => 'required|digits:16|unique:people,identityNumber',
            'familyIdentityNumber' => 'required|digits:16',
            'gender' => 'required|in:male,female',
            'streetAddress' => 'required|string|max:50',
            'religion' => 'required|integer',
            'provinceId' => 'required|integer',
            'regencieId' => 'required|integer',
            'districtId' => 'required|integer',
            'villageId' => 'required|integer',
            'kontingenId' => 'nullable|integer',
            'probabilityId' => 'required|uuid|exists:probability,id',
            'phoneNumber' => ['required', 'regex:/^(628|08)[0-9]{7,11}$/'],
            'email' => 'nullable|email',
            'height' => 'nullable|numeric|min:80|max:300',
            'weight' => 'nullable|numeric|min:40|max:300',
            'documentId' => 'nullable|uuid',
            'userId' => 'nullable|uuid',
        ], [
            'fullName.required' => 'Nama lengkap wajib diisi.',
            'fullName.max' => 'Nama lengkap maksimal 40 karakter.',
            'identityNumber.required' => 'Nomor Induk Kependudukan wajib diisi.',
            'identityNumber.digits' => 'NIK harus terdiri dari 16 digit.',
            'identityNumber.unique' => 'NIK sudah terdaftar.',
            'familyIdentityNumber.required' => 'Nomor KK wajib diisi.',
            'familyIdentityNumber.digits' => 'Nomor KK harus 16 digit.',
            'phoneNumber.required' => 'Nomor handphone wajib diisi.',
            'phoneNumber.regex' => 'Nomor handphone harus diawali dengan 628 atau 08 dan terdiri dari 10–13 digit angka.',
            'birthdate.required' => 'Tanggal lahir wajib diisi.',
            'birthdate.date' => 'Format tanggal lahir tidak valid.',
            'birthdate.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'streetAddress.required' => 'Alamat wajib diisi.',
            'streetAddress.max' => 'Alamat maksimal 50 karakter.',
            'religion.required' => 'Agama wajib dipilih.',
            'provinceId.required' => 'Provinsi wajib dipilih.',
            'regencieId.required' => 'Kabupaten/Kota wajib dipilih.',
            'districtId.required' => 'Kecamatan wajib dipilih.',
            'villageId.required' => 'Desa wajib dipilih.',
            'height.numeric' => 'Tinggi badan harus berupa angka.',
            'height.min' => 'Tinggi badan minimal 80 cm.',
            'probabilityId.required' => 'Bagian Peruntukan wajib dipilih salah satu.',
            'height.max' => 'Tinggi badan tidak boleh lebih dari 300 cm.',
            'weight.numeric' => 'Berat badan harus berupa angka.',
            'weight.min' => 'Berat badan minimal 40 kg.',
            'weight.max' => 'Berat badan tidak boleh lebih dari 300 kg.',
        ]);

        // Validasi usia minimal 10 tahun
        $birthdate = Carbon::parse($data['birthdate']);
        $today = Carbon::today();
        $days = $birthdate->diffInDays($today);

        if ($days < 3650) {
            return response()->json([
                'message' => 'Usia belum memenuhi syarat minimal 10 tahun.',
                'errors' => [
                    'birthdate' => ['Usia belum memenuhi syarat minimal 10 tahun ke atas.']
                ]
            ], 422);
        }

        $age = $birthdate->diffInYears($today);
        if ($birthdate->copy()->addYears($age)->isAfter($today)) {
            $age--;
        }

        $data['age'] = $age;
        $idKontingens = (int) $data['kontingenId'];
        $kontingen = Kontingen::where('regencies_id', $idKontingens)->first();
        // Handle kontingenId jika null
        if (empty($kontingen)) {
            $kontingen = Kontingen::create([
                'province_id' => 11,
                'regencies_id' => $idKontingens,
            ]);
        }
        $data['kontingenId'] = $kontingen->id;
        // dd($kontingenId, $data);
        $person = Person::create($data);

        return new PersonResource($person);
    }

    public function show($id)
    {
        return new PersonResource(Person::findOrFail($id));
    }

    public function edit($id)
    {
        $person = Person::with([
            'province',
            'regencie',
            'district',
            'village',
            'kontingen',
            'document'
        ])->findOrFail($id);

        return (new PersonResource($person))->forEdit();
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $person = Person::findOrFail($id);
        $data = $request->validate([
            'fullName' => 'required|string|max:40',
            'birthdate' => 'required|date|before:today',
            'identityNumber' => [
                'required',
                'digits:16',
                Rule::unique('people', 'identityNumber')->ignore($person->id),
            ],
            'familyIdentityNumber' => 'required|digits:16',
            'gender' => 'required|in:male,female',
            'streetAddress' => 'required|string|max:50',
            'religion' => 'required|integer',
            'provinceId' => 'required|integer',
            'regencieId' => 'required|integer',
            'districtId' => 'required|integer',
            'villageId' => 'required|integer',
            'kontingenId' => 'nullable|integer',
            'phoneNumber' => ['required', 'regex:/^(628|08)[0-9]{7,11}$/'],
            // 'probabilityId' => 'required|uuid|exists:probability,id',
            'email' => 'nullable|email',
            'height' => 'nullable|numeric|min:80|max:300',
            'weight' => 'nullable|numeric|min:40|max:300',
            'documentId' => 'nullable|uuid',
            'userId' => 'nullable|uuid',
        ], [
            // Pesan error sama seperti di store()
            'fullName.required' => 'Nama lengkap wajib diisi.',
            'fullName.max' => 'Nama lengkap maksimal 40 karakter.',
            'identityNumber.required' => 'Nomor Induk Kependudukan wajib diisi.',
            'identityNumber.digits' => 'NIK harus terdiri dari 16 digit.',
            'identityNumber.unique' => 'NIK sudah terdaftar.',
            'familyIdentityNumber.required' => 'Nomor KK wajib diisi.',
            'familyIdentityNumber.digits' => 'Nomor KK harus 16 digit.',
            'phoneNumber.required' => 'Nomor handphone wajib diisi.',
            'phoneNumber.regex' => 'Nomor handphone harus diawali dengan 628 atau 08 dan terdiri dari 10–13 digit angka.',
            'birthdate.required' => 'Tanggal lahir wajib diisi.',
            'birthdate.date' => 'Format tanggal lahir tidak valid.',
            'birthdate.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'streetAddress.required' => 'Alamat wajib diisi.',
            'streetAddress.max' => 'Alamat maksimal 50 karakter.',
            'religion.required' => 'Agama wajib dipilih.',
            'provinceId.required' => 'Provinsi wajib dipilih.',
            'regencieId.required' => 'Kabupaten/Kota wajib dipilih.',
            'districtId.required' => 'Kecamatan wajib dipilih.',
            'villageId.required' => 'Desa wajib dipilih.',
            'height.numeric' => 'Tinggi badan harus berupa angka.',
            'probabilityId.required' => 'Bagian Peruntukan wajib dipilih salah satu.',
            'height.min' => 'Tinggi badan minimal 80 cm.',
            'height.max' => 'Tinggi badan tidak boleh lebih dari 300 cm.',
            'weight.numeric' => 'Berat badan harus berupa angka.',
            'weight.min' => 'Berat badan minimal 40 kg.',
            'weight.max' => 'Berat badan tidak boleh lebih dari 300 kg.',
        ]);

        // Validasi usia minimal 10 tahun
        $birthdate = Carbon::parse($data['birthdate']);
        $today = Carbon::today();
        $days = $birthdate->diffInDays($today);

        if ($days < 3650) {
            return response()->json([
                'message' => 'Usia belum memenuhi syarat minimal 10 tahun.',
                'errors' => [
                    'birthdate' => ['Usia belum memenuhi syarat minimal 10 tahun ke atas.']
                ]
            ], 422);
        }

        // Hitung ulang usia
        $age = $birthdate->diffInYears($today);
        if ($birthdate->copy()->addYears($age)->isAfter($today)) {
            $age--;
        }

        $data['age'] = $age;
        $idKontingens = (int) $data['kontingenId'];
        $kontingen = Kontingen::where('regencies_id', $idKontingens)->first();
        // Handle kontingenId jika null
        if (empty($kontingen)) {
            $kontingen = Kontingen::create([
                'province_id' => 11,
                'regencies_id' => $idKontingens,
            ]);
        }
        $data['kontingenId'] = $kontingen->id;
        $person->update($data);

        return new PersonResource($person);
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        if ($person->documentId) {
            return response()->json(['message' => 'Cannot delete person with related document.'], 409);
        }
        $person->delete();
        return response()->noContent();
    }
}
