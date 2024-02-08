<div>
    @if ($selected_id > 0)
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="mb-4">
                                    Nombre del Proveedor: <strong>{{ $provider->name }}</strong>
                                </h5>
                                <button type="button" wire:click='doAction(0)' class="btn btn-outline-secondary btn-rounded btn-icon float-right">
                                    <i class="fas fa-trash text-danger">
                                    </i>
                                </button>
                                <p class="ml-5">Ruc: <strong>{{ $provider->ruc_number }}</strong></p>
                                <p class="ml-5">Telefono: <strong>{{ $provider->phone }}</strong></p>
                                <p class="ml-5">Email: <strong>{{ $provider->email }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body mb-3">
                                <label><strong>Tipo de Documento: </strong></label>
                                <select id="type" class="form-control text-center" wire:model='type'>
                                    <option value="Elegir">---Seleccione--</option>
                                    <option value="Factura">---Factura--</option>
                                    <option value="Recivo">---Recivo--</option>
                                    <option value="Proforma">---Proforma--</option>
                                </select>
                                <div class="col-md-6 float-left mt-2">
                                    <label>Fechas de Compra: </label>
                                    <input type="date" class="form-control" wire:model='purchase_date'>
                                </div>
                                <div class="col-md-6 float-left mt-2">
                                    <label>Numero de Documento: </label>
                                    <input type="text" class="form-control" wire:model='number_fact'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <label>Seleccione un Proveedor</label>
                                <select class="form-control from-control-lg" wire:model.lazy='selected_id'>
                                    <option value="Elegir">---Seleccione--</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="form-control">
        <div class="row">
            <div class="col-md-5 grid-margin">
                <div class="form-group" wire:ignore>
                    <label><strong>Buscar Producto: </strong></label>
                    <select class="form-control form-control-lg" wire:model='product_id'>
                        <option value="Elegir">--Selecciona un Producto--</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong>Cantidad: </strong></label>
                    <input type="number" wire:model='quantity' class="form-control" placeholder="cantidad">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong>Precio de Compra: </strong></label>
                    <input type="number" wire:model='buy_price' class="form-control" placeholder="Precio de Compra">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong>Precio de Venta: </strong></label>
                    <input type="number" wire:model='sell_price' class="form-control" placeholder="¨Precio de Venta">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <button class="btn btn-primary float-right mt-4 ml-2" wire:click.prevent='addProduct()'>Agregar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card px-2">
                    <div class="card-body">
                        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                            <div class="table-responsive w-100">
                                <table class="table">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th class="text-right">Cantidad</th>
                                            <th class="text-right">Precio Compra</th>
                                            <th class="text-right">Precio de Venta</th>
                                            <th class="text-right">SubTotal</th>
                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderProducts as $key => $product)
                                            <tr class="text-center" wire:key='{{ $key }}'>
                                                <td class="text-left">{{ $key + 1 }}</td>
                                                <td class="text-left">{{ $product['name'] }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>{{ $product['buy_price'] }}</td>
                                                <td>{{ $product['sell_price'] }}</td>
                                                <td>{{ $product['itemtotal'] }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" wire:click.prevent='removeItems({{$key}})'>X</button>
                                                </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid mt-5 w-100">
                            <p class="text-right mb-2">SubTotal: ${{ $subtotal }}</p>
                            <p class="text-right mb-2">IVA(12%): ${{ $taxiva }}</p>
                            <h4 class="text-right mb-2">Total: ${{ $total }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mr-2 mt-4 float-right">
        <a href="{{ route('purchases.index') }}" class="btn btn-light"> Cancelar </a>
        <button type="submit" class="btn btn-primary" wire:click.prevent='storeOrden()'>Guardar</button>
    </div>
</div>
