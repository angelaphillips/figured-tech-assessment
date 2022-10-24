<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Inventory Management</title>
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="container-fluid mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>Inventory Management</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Request Quantity</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventory as $inv)
                            <tr>
                                <th scope="row">{{ $inv->id }}</th>
                                <td>{{ $inv->name }}</td>
                                <td>
                                    <input type="hidden" name="" value="{{ $inv->id }}">
                                    <input type="number" min="1" name="units_requested" id="units_requested_<?= $inv->id ?>">
                                </td>
                                <td><button type="submit" class="btn btn-primary" onclick="requestInventory({{ $inv->id }})">Request Inventory</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script>
        function requestInventory(inventory_id) {
            let data = {
                'inventory_id' : inventory_id,
                'units_requested' : document.getElementById('units_requested_'+inventory_id).value
            };
            window.axios.post('/request_inventory', data)
                .then(res => {
                   confirm(res.data.message);
                }).catch(err => {
                    alert(err.message);
            })
        }
    </script>
</html>
