@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <div class="row justify-content-center">
                        <a href="/create" class="btn btn-outline-success">Create</a>
                        <hr>
                    </div>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <table id="superHeroesTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Thumbnails</th>
                                <th>Nickname</th>
                                <th>Real Name</th>
                                <th>Origin Description</th>
                                <th>Superpowers</th>
                                <th>Catch Phrase</th>
                                <th>Created_at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const bulk_selected_btns = '<select class="bulk-action btn btn-light" size="1">' +
            '<option value="">-- Select Action --</option>' +
            '<option value="delete">Delete</option>' +
            '</select>' +
            '<button id="buckActionSubmit" class="ml-2 btn btn-outline-danger"> Submit Action </button>';
        jQuery(document).ready(function ($) {
            let superHeroesTable = $('#superHeroesTable').DataTable({
                stateSave: true,
                "processing": true,
                "serverSide": true,
                "columns": [
                    {title: "#", data: ''},
                    {title: "Thumbnails", data: 'thumbnails', "defaultContent": "<i>N/A</i>"},
                    {title: "Nickname", data: 'nickname', "defaultContent": "<i>N/A</i>"},
                    {title: "Real Name", data: 'real_name', "defaultContent": "<i>N/A</i>"},
                    {title: "Origin Description", data: 'origin_description', "defaultContent": "<i>N/A</i>"},
                    {title: "Superpowers", data: 'superpowers', "defaultContent": "<i>N/A</i>"},
                    {title: "Catch Phrase", data: 'catch_phrase', "defaultContent": ""},
                    {title: "Added", data: 'added', "defaultContent": "<i>N/A</i>"},
                ],
                "columnDefs": [
                    {
                        targets: 0, sortable: false,
                        "render": function (data, type, row) {
                            return '<input type="checkbox" class="bulk-action-checkbox"  value="' +
                                row.id + '" >'
                        },
                    },
                    {
                        targets: 1, sortable: false, "orderable": false,

                        "render": function (data, type, row) {
                            if (row.url) {
                                return '<img src="' + row.url + '" width="100px" height="100px">'
                            } else {
                                return "<i>N/A</i>"
                            }
                        },

                    },
                    {
                        targets: 2,
                        "render": function (data, type, row) {
                            return '<a href="/edit/' + row.id + '">' + row.nickname + '</a>'
                        },

                    },
                    {
                        targets: 8,
                        "render": function (data, type, row) {
                            return '<a class="btn btn-outline-dark" href="/edit/' + row.id + '">Edit</a>';
                        }
                    },
                ],
                "ajax": {
                    "url": "/super_heroes_list",
                },
                "order": [[2, 'asc']],
                initComplete: function () {
                    $('.dataTables_length').after(bulk_selected_btns);
                },
                "drawCallback": function () {
                }
            });

            $(document).on('click', '#buckActionSubmit', function () {
                let action = $('.bulk-action').val();
                if (action === 'delete') {
                    let ids = [];
                    let counter = 0;
                    $('.bulk-action-checkbox').each(function () {
                        if ($(this).is(":checked")) {
                            ids[counter] = $(this).val();
                            counter++;
                        }
                    });
                    if (counter > 0) {
                        swal({
                            title: "Are you sure you want to Delete selected items?",
                            text: "",
                            icon: "warning",
                            buttons: {
                                roll: {
                                    text: "Cancel",
                                    value: false,
                                    className: 'btn-warning'
                                },
                                confirm: "Yes",
                                value: false,
                            },
                        }).then((confirm) => {
                            if (confirm) {
                                $.ajax({
                                    type: "GET",
                                    data: {
                                        ids: ids,
                                        '_token': '{{ csrf_token() }}'
                                    },
                                    url: '/bulk_delete',
                                    success: function (msg) {
                                        if (msg.status) {
                                            swal('Success', msg.message, 'success')
                                            superHeroesTable.ajax.reload();
                                            jQuery('.bulk-action').val('');

                                        } else {
                                            swal('Error', msg.message, 'error')
                                            superHeroesTable.ajax.reload();
                                            jQuery('.bulk-action').val('');
                                        }
                                    }
                                });
                            }
                        });
                    } else {
                        swal("No item selected", {
                            icon: "warning",
                        });
                    }
                }
            });
        });
    </script>
@endpush

