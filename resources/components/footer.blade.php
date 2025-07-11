    <script src="{{ asset('assets') }}/js/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/icons/feather-icon/feather-icon.js"></script>
    <script src="{{ asset('assets') }}/js/scrollbar/simplebar.js"></script>
    <script src="{{ asset('assets') }}/js/scrollbar/custom.js"></script>
    <script src="{{ asset('assets') }}/js/config.js"></script>
    <script src="{{ asset('assets') }}/js/sidebar-menu.js"></script>
    <script src="{{ asset('assets') }}/js/prism/prism.min.js"></script>
    <script src="{{ asset('assets') }}/js/clipboard/clipboard.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-card/custom-card.js"></script>
    <script src="{{ asset('assets') }}/js/form-validation-custom.js"></script>
    <script src="{{ asset('assets') }}/js/tooltip-init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{ asset('assets') }}/js/sweet-alert/sweetalert.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/js/sweet-alert/app.js"></script> --}}
    @isset($table)
    <script src="{{ asset('assets') }}/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.select.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="{{ asset('assets') }}/js/datatable/datatable-extension/custom.js"></script>
    @endisset
    <script src="{{ asset('assets') }}/js/script.js"></script>
    @if (!isset($section) || $section != 'dokumen')

        <script src="{{ asset('assets') }}/js/input-file.js"></script>

    @endif
    <script src="{{ asset('assets') }}/js/disable-autocomplete.js"></script>
    <script src="{{ asset('assets') }}/js/custom-map.js"></script>
