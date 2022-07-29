@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
    <form action="#" method="GET" class="form-filter form-create">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" id="filter_title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="filter_variant" class="form-control">
                    <option value="">-- Select A Variant--</option>
                    
                            @foreach($variantsname as $varientname)
                            <option value="">&ensp;{{$varientname->title}}</option>
                            @foreach($varientname->productVariant as $pro_variant)
                            @if($pro_variant->variant_id == $varientname->id)
                            &ensp<option value="{{ $pro_variant->variant}}">&emsp;&emsp;{{$pro_variant->variant }}</option>
                            @endif
                            @endforeach
                            @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" id="filter_fprice aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" id="filter_tprice" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" id="filter_date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" id="filter" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">

                <table id="dataTable" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>


                    <!-- <tbody>

                        <tr>
                            <td>1</td>
                            <td>T-Shirt <br> Created at : 25-Aug-2020</td>
                            <td>Quality product in low cost</td>
                            <td>
                                <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                    <dt class="col-sm-3 pb-0">
                                        SM/ Red/ V-Nick
                                    </dt>
                                    <dd class="col-sm-9">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4 pb-0">Price : {{ number_format(200,2) }}</dt>
                                            <dd class="col-sm-8 pb-0">InStock : {{ number_format(50,2) }}</dd>
                                        </dl>
                                    </dd>
                                </dl>
                                <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>

                    </tbody> -->

                </table>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
<script>

$(function() {

    var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                searching: false,
                order: [[0, "desc"]],
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
                mark: true,
                language: {
                    infoFiltered: "",
                    info: "Showing _START_ to _END_ out of _TOTAL_ ",
                    infoEmpty: ""
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'variant', name: 'variant'},
                    {data: 'action', name: 'Action'}

    
                ],
                ajax: {
                    url: '{{ route("product.data") }}',
                    data: function (d) {
                        $(".form-filter").serializeArray().map(function (x) {
                            d[x.name] = x.value;
                        });
                    }
                }
            });
            $('.form-filter').on('submit', function (e) {
                table.draw();
                e.preventDefault();
            });


});
</script>
    
@endpush