<style type="text/css">
    tfoot tr td{
        font-weight: bold;
    }
    .gray {
        background-color: lightgray
    }
</style>
  <table width="100%">
    <tr>
        <td align="top"><img width="150px" heigth="150px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsBAMAAACLU5NGAAAAG1BMVEXMzMyWlpa3t7eqqqqcnJyjo6PFxcWxsbG+vr6NAD6nAAAACXBIWXMAAA7EAAAOxAGVKw4bAAACjklEQVR4nO3XO2/bMBDA8fNTGn2OlGS00S8QAWnnaKi7xnBQdJSBFl3joY/RRpHv3SNFykYtdKOm/w8BHOkOIM3HkRYBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/uddvWvsI38sj+7xT/2lJ2n8WH64iMbkdCaqurTPteqda98eX6+zKnu9OkdDckIH3W21kbmWlR5F9rrT+6ukTMv3ettFY3JC9UZyfZBJ0czrZxuWjXwtr5KmRSOnmy4ak9PJ3bc+PMveJvJ0a+OwslfNv1knG6Ks7KIhOaGxulYXsl7YmNy1j/XV4nLRXLtoSE4oczN2epLK5mRSuj/x/7tuPImfOfHDKXnRRUNyaq6l17bhu7aX/q1N1fY8Va7TIRqSE/tuS2a78i3Nludu7QsbsW4+54dlFw3JadVqM1Uf3b6XqSsO+4V/n+nrtGt7qrZdYzQkp6WuFLUtNW3DYebqzXoZk0ZqWzZGQ3LqblmLvhFtRq5Ho9Ct9c25OI1c52M0JKftlrzpc+9ozfSilOfbctjRsv226FtbtuBvLpJmOuza8hW7Zyfa4lpeJFl5H24nZr/Fz4srReNQt9ahW5nGpn8d/azFaEhOyJ8hNi+HtnBn5yrvClcsW+44slmL0UPyKj8Jh0/fmVjd12HxV+3hM+CZ6DZUFW4Q9+GOcPShuT6sw5o/3PovEKMhOaG5frZBWPXdt2a2xkMV2JeNuNI62H1LqmJXF9J3O7XbQ65t4xP9+OguFMPdTr9Zkd9I313eLaxt28X5VtUuqAPe5eVH/ckalPyl/THzFn/5jF0H9qEMZC/Fz4toTAYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEjpL514clJrNSt2AAAAAElFTkSuQmCC" alt="">
</td>
        <td align="right">
            <h1>{{ config('app.name')}}</h1>

        </td>
    </tr>
    <tr>
      <td></td>
      <td align="right"><h3><strong><i>{{ $invoice->name }}</i></strong></h3></td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td><strong>Van:</strong> {{ config('app.name')}}</td>
        <td align="right"><strong>Begunstige:</strong> {{ $invoice->user->name }}</td>
    </tr>
  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Naam</th>
        <th>Aantal</th>
        <th>Prijs per item</th>
        <th>Totaal</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      @foreach($invoice->attributes as $line)
        <tr>
          <th scope="row">{{ $i }}</th>
          <td>{{ $line->name }}</td>
          <td align="right">{{ $line->quantity }}</td>
          <td align="right">€ {{ $line->price }}</td>
          <td align="right">€ {{ $line->quantity * $line->price }}</td>
        </tr>
        <?php $i++; ?>
      @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="right">Subtotaal</td>
            <td align="right">
              <?php $subtotal = 0; ?>
              @foreach($invoice->attributes as $line)
                <?php $subtotal += $line->quantity * $line->price; ?>
              @endforeach
              {{ round($subtotal, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right">BTW</td>
            <td align="right">{{ round($subtotal * .21, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="right">Totaal</td>
            <td align="right" class="gray">{{ round(($subtotal * .21) + $subtotal, 2) }}</td>
        </tr>
    </tfoot>
  </table>

  <br/>

  <table width="100%">
    <tr>
        <td><p>Deze factuur is te voldoen voor {{ $invoice->dueDate->format('d/m/Y') }}<br><br>© {{ date('Y') }} {{ config('app.name')}}. All rights reserved.</p></td>
    </tr>
  </table>
