<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container-fluid my-3">
        <h2>{{$order->user->name}}</h2>
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        
                        <div class="my-3">
                            <h6>{{$order->user->name}}</h6>
                            <p>{{$order->address}}</p>
                        </div>
                    </td>
                    <td>
                        <table class="table my-3">
                            <tbody>
                                <tr>
                                    <td><h4 class="text-uppercase">
                                        order #
                                    </h4></td>
                                    <td>
                                        <div class="fs-6">{{$order->id}}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="text-uppercase">
                                            order date
                                        </h4>
                                    </td>
                                    <td>
                                        <div class="fs-6">{{$order->created_at->format('Y/m/d')}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table my-5">
            <thead style="background-color: #e2e3e5">
                <tr>
                    <th class="p-2">Delevery date</th>
                    <th class="p-2">Shipping method</th>
                    <th class="p-2">Shipping terms</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-2">{{date('Y/m/d')}}</td>
                    <td class="p-2">FedEx</td>
                    <td class="p-2">tracked shipment</td>
                </tr>
            </tbody>
        </table>
        <table class="table my-5">
            <thead style="background-color: #e2e3e5">
                <tr>
                    <th class="p-2">Item</th>
                    <th class="p-2">Title</th>
                    <th class="p-2">Quantity</th>
                    <th class="p-2">Unit Cost</th>
                    <th class="p-2">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($order->details_order as $item)
                    <tr >
                        <td class="p-2">{{$item->id}}</td>
                        <td class="p-2">{{$item->product_title}}</td>
                        <td class="p-2">{{$item->quantity}}</td>
                        <td class="p-2">${{$item->price}}</td>
                        <td class="p-2">${{$item->price * $item->quantity}}</td>
                    </tr>
                    @php
                        $total += $item->price * $item->quantity;
                    @endphp
                @endforeach
            </tbody>
        </table>
            
               
            

        <div class="mt-5" style="width:400px;margin-left:auto;">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="text-uppercase p-2">subtotal</td>
                        <div class="text-end p-2">${{$total}}</div>
                    </tr>
                    <tr>
                        <td class="text-uppercase p-2">tva (0%)</td>
                        <td class="text-end p-2">$0.00</td>
                    </tr>
                </tbody>
                <tfoot style="background-color: #e2e3e5">
                    <tr>
                        <th class="p-2">total</th>
                        <th class="text-end p-2">${{$total}}</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</body>
</html>