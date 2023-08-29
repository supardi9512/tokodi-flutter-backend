<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; {{ $product->name }} &raquo; Gallery
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX DataTable
            var dataTable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [
                    { data: 'id', name: 'id', width: '5%'},
                    { data: 'url', name: 'url' },
                    { data: 'is_featured', name: 'is_featured' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%'
                    },
                ],
                order: [[0, 'desc']]
            });

            dataTable.on('order.dt search.dt page.dt', function () {
                var start = dataTable.page.info().start;
                var info = dataTable.page.info();
                dataTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = start+i+1;
                } );
            } ).draw();
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.product.gallery.create', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Upload Photos
                </a>
            </div>
            @if(session()->has('success'))
                <div class="mb-5" role="alert">
                    <div class="px-4 py-2 font-bold bg-green-200 border border-green-500 rounded">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                        <tr>
                            <th class="px-2 py-4">No.</th>
                            <th class="px-6 py-4">Photo</th>
                            <th class="px-6 py-4">Featured</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
