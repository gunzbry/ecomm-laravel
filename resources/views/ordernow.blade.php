@extends('master')
@section('content')
<div class="custom-product">
    <div class="row">
        <div class="col-sm-10">
            <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Amount</td>
                    <td>$ {{ $total }}</td>
                  </tr>
                  <tr>
                    <td>Tax</td>
                    <td>$ 0</td>
                  </tr>
                  <tr>
                    <td>Delivery Charges</td>
                    <td>$ 10</td>
                  </tr>
                  <tr>
                    <td>Total Amount</td>
                    <td>$ {{ $total+10 }}</td>
                  </tr>
                </tbody>
              </table>
              <div>
                <form action="/orderplace" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="email">Address</label>
                      <textarea name="address" placeholder="Enter your address" class="form-control" id="email"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="pwd">Payment Method:</label>
                      <br/>
                      <input type="radio" value="online" name="payment"><span>OnlinePayment</span><br/>
                      <input type="radio" value="emi" name="payment"><span>EMI Payment</span><br/>
                      <input type="radio" value="cod" name="payment"><span>Payment on Delivery</span><br/>

                    </div>
                    <button type="submit" class="btn btn-default">Order Now</button>
                  </form>
              </div>
        </div>    
    </div>
</div>
@endsection