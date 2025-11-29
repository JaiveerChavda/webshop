<x-mail::message>
Hi, {{ $order->user->name }}

Thank you for your order. Find your order details below.

<table style="width: 100%">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td align="left">{{ $item->name }} <br/> {{ $item->description }}</td>
                <td align="center">{{ $item->price }}</td>
                <td align="center">{{ $item->quantity }}</td>
                <td align="center">{{ $item->amount_tax }}</td>
                <td align="center">{{ $item->amount_total }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @if ($order->amount_discount->isPositive())
            <tr>
                <td colspan=4 style="text-align: right">Discount</td>
                <td style="text-align: center">{{ $order->amount_discount }}</td>
            </tr>
            @endif
            @if ($order->amount_shipping->isPositive())
            <tr>
                <td colspan=4 style="text-align: right">Shipping costs</td>
                <td style="text-align: center">{{ $order->amount_shipping }}</td>
            </tr>
            @endif
            @if ($order->amount_tax->isPositive())
            <tr>
                <td colspan=4 style="text-align: right">Tax</td>
                <td style="text-align: center">{{ $order->amount_tax }}</td>
            </tr>
            @endif
            @if ($order->amount_subtotal->isPositive())
            <tr>
                <td colspan="4" style="text-align: right">Subtotal</td>
                <td style="text-align: center">{{ $order->amount_subtotal }}</td>
            </tr>
            @endif
            @if ($order->amount_total->isPositive())
            <tr>
                <td colspan="4" style="text-align: right">Total</td>
                <td style="text-align: center">{{ $order->amount_total }}</td>
            </tr>
            @endif
        </tfoot>
</table>
</x-mail::message>