@extends('layouts.app')

@section('title', __('client.order'))

@section('content')
  @isset($featured)
    @include("partials.barnners-grid")
  @endisset
  <style>
    .table td { vertical-align: middle; }
    .parsley-errors-list { color: red; }
    .lds-grid {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-grid div {
      position: absolute;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: #fff;
      animation: lds-grid 1.2s linear infinite;
    }
    .lds-grid div:nth-child(1) {
      top: 8px;
      left: 8px;
      animation-delay: 0s;
    }
    .lds-grid div:nth-child(2) {
      top: 8px;
      left: 32px;
      animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(3) {
      top: 8px;
      left: 56px;
      animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(4) {
      top: 32px;
      left: 8px;
      animation-delay: -0.4s;
    }
    .lds-grid div:nth-child(5) {
      top: 32px;
      left: 32px;
      animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(6) {
      top: 32px;
      left: 56px;
      animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(7) {
      top: 56px;
      left: 8px;
      animation-delay: -0.8s;
    }
    .lds-grid div:nth-child(8) {
      top: 56px;
      left: 32px;
      animation-delay: -1.2s;
    }
    .lds-grid div:nth-child(9) {
      top: 56px;
      left: 56px;
      animation-delay: -1.6s;
    }
    @keyframes lds-grid {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0.5;
      }
    }
    .bg-loader {
      background-color: rgba(0, 0, 0,0.9);
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-open .modal { z-index: 99999; }
  </style>
  <div class="bg-loader">
    <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>
  <div class="container mt-3 mb-4">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th></th>
          <th>{{__('client.productName')}}</th>
          <th>{{__('client.properties')}}</th>
          <th>{{__('client.price')}}</th>
          <th>{{__('client.amount')}}</th>
          <th>{{__('client.total')}}</th>
          <th></th>
        </tr>
        </thead>
        <tbody class="cart"></tbody>
        <tfoot>
        <tr>
          <td colspan="5" align="right">{{__('client.totalAmountOfGoods')}}</td>
          <th align="left" colspan="2"><strong class="base-total-price">0</strong><strong>₫</strong></th>
        </tr>
        <tr>
          <td colspan="5" align="right">{{__('client.transportFee')}}</td>
          <th align="left" colspan="2"><strong class="shipping-cost">0</strong><strong>₫</strong></th>
        </tr>
        <tr>
          <td colspan="5" align="right">{{__('client.totalPayment')}}</td>
          <th align="left" colspan="2"><strong class="grand-total">0</strong><strong>₫</strong></th>
        </tr>
        </tfoot>
      </table>
    </div>
    <form name="order-form" id="order-form">
      <div class="form-group name">
        <label>{{__('client.fullName')}}</label>
        <input type="text" name="full_name" class="form-control" placeholder="{{__('client.pleaseEnterYourFullNameHere')}}" required data-parsley-errors-container=".form-group.name">
      </div>
      <div class="form-group email">
        <label>{{__('client.emailAddress')}}</label>
        <input type="email" name="email" class="form-control" placeholder="{{__('client.pleaseEnterYourEmailAddressHere')}}" required data-parsley-errors-container=".form-group.email">
      </div>
      <div class="form-group tel">
        <label>{{__('client.phoneNumber')}}</label>
        <input type="tel" name="phone_number" class="form-control" placeholder="{{__('client.pleaseEnterYourPhoneNumberHere')}}" required data-parsley-errors-container=".form-group.tel">
      </div>
      <div class="form-group address">
        <label>{{__('client.shippingAddress')}}</label>
        <input type="text" name="address" class="form-control" placeholder="{{__('client.pleaseEnterYourShippingAddressHere')}}" required data-parsley-errors-container=".form-group.address">
      </div>
      <div class="form-group">
        <label>{{__('client.note')}}</label>
        <textarea name="notes" class="form-control" rows="3"></textarea>
      </div>
      <div class="text-right">
        <button type="submit" class="btn btn-danger btn-order">{{__('client.order')}}</button>
      </div>
    </form>
    <div class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{__('client.orderSuccess')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{__('client.congratulationsOnYourSuccessfulOrder')}}</p>
            <p><strong>{{__('client.fullName')}}</strong> <span class="final-name"></span></p>
            <p><strong>{{__('client.emailAddress')}}</strong> <span class="final-email"></span></p>
            <p><strong>{{__('client.phoneNumber')}}</strong> <span class="final-tel"></span></p>
            <p><strong>{{__('client.shippingAddress')}}</strong> <span class="final-address"></span></p>
            <p><strong>{{__('client.note')}}</strong> <span class="final-note"></span></p>
            <table class="table table-striped">
              <thead>
              <tr>
                <th></th>
                <th>{{__('client.productName')}}</th>
                <th>{{__('client.properties')}}</th>
                <th>{{__('client.price')}}</th>
                <th>{{__('client.amount')}}</th>
                <th>{{__('client.total')}}</th>
              </tr>
              </thead>
              <tbody class="cart-final"></tbody>
              <tfoot>
              <tr>
                <td colspan="5" align="right">{{__('client.totalAmountOfGoods')}}</td>
                <th align="left"><strong class="base-total-price-final">0</strong><strong>₫</strong></th>
              </tr>
              <tr>
                <td colspan="5" align="right">{{__('client.transportFee')}}</td>
                <th align="left"><strong class="shipping-cost-final">0</strong><strong>₫</strong></th>
              </tr>
              <tr>
                <td colspan="5" align="right">{{__('client.totalPayment')}}</td>
                <th align="left"><strong class="grand-total-final">0</strong><strong>₫</strong></th>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include("partials.slide-brand", ["classExtend" => "", "array" => $brands])
@endsection
@section("script")
  <script>
    const nameCookie = "shop-hung";
    const body = $("body");
    body.css("overflow", "hidden");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    const input = {
      "base_total_price": 0,
      "shipping_cost": 0,
      "grand_total": 0,
      "item_count": 0,
    };

    $("input[type='tel']").inputmask("(999) 999-9999");
    $('#order-form').parsley().on('form:submit', function(e) {
      for (let i = 0; i < e.fields.length; i++) {
        input[e.fields[i].element.name] = e.fields[i].value;
      }
      const ids = product.map(item => item.product_attribute_id);
      body.css("overflow", "hidden");
      $(".bg-loader").fadeIn();
      $.ajax({
        method: "POST",
        url: "/order",
        data: { input, product, ids },
        success:function(data){
          $(".bg-loader").fadeOut();
          if (data) {
            const {order, orderItem} = data;
            $(".base-total-price-final").text(order["base_total_price"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $(".shipping-cost-final").text(order["shipping_cost"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $(".grand-total-final").text(order["grand_total"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $(".final-name").text(order["full_name"]);
            $(".final-email").text(order["email"]);
            $(".final-tel").text(order["phone_number"]);
            $(".final-address").text(order["address"]);
            if (order["note"]) $(".final-note").text(order["note"]);

            $(".cart-final").html("");
            orderItem.map((item, index) => {
              const subtotal = (item.price * item.quantity) + "";
              const html = $("<html>").append(
                $("<tr>").append(
                  $("<td>").append(
                    $("<div>").append(
                      $("<img>", { src: product[index].linkImage, width: 50 })
                    ),
                  ),
                  $("<td>").append(
                    $("<a>", { href: product[index].url }).append(item.name)
                  ),
                  $("<td>").append(
                    $("<pre>", { class: "mb-0" }).append(item.name_attribute)
                  ),
                  $("<td>").append(
                    $("<strong>").append(item.price.replace(/\B(?=(\d{3})+(?!\d))/g, ',')),
                    $("<strong>").append("₫")
                  ),
                  $("<td>").append(
                    $("<div>").append(item.quantity)
                  ),
                  $("<td>").append(
                    $("<strong>").append(subtotal.replace(/\B(?=(\d{3})+(?!\d))/g, ',')),
                    $("<strong>").append("₫")
                  )
                )
              ).html();
              $(".cart-final").append(html);
            });
            Cookies.set(nameCookie, "[]");
            $('.modal').modal('show').on('hidden.bs.modal', function (event) {
              document.location.href = "/";
            })
          } else document.location.href = "/";
        }
      });
      return false;
    });

    let product = Cookies.get(nameCookie);
    product = JSON.parse(product);
    console.log(product)
    const data = product.map(item => item.product_attribute_id)
    $.ajax({
      method: "POST",
      url: "/cart",
      data: {
        ...data
      },
      success:function(data){
        product = product.map(item => {
          data.map(subItem => {
            if (item.product_attribute_id === subItem.id) {
              item.quantity = subItem.quantity >= item.quantity ? item.quantity : 0;
              item.price = !!subItem.sale_price ? subItem.sale_price : subItem.price;
              item.maxQuantily = subItem.quantity > item.quantity ? subItem.quantity - item.quantity : item.quantity;
            }
          })
          item.total = item.price * item.quantity;
          input["base_total_price"] += item.total;
          input["item_count"] += parseInt(item.quantity);
          return item;
        });
        input["shipping_cost"] = input["base_total_price"] < 500000 ? 35000 : 0;
        input["grand_total"] = input["base_total_price"] < 500000 ? input["base_total_price"] + 35000 : input["base_total_price"];
        const baseTotalPrice = $(".base-total-price");
        const shippingCost = $(".shipping-cost");
        const grandTotal = $(".grand-total");
        baseTotalPrice.text(input["base_total_price"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        shippingCost.text(input["shipping_cost"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        grandTotal.text(input["grand_total"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

        Cookies.set(nameCookie, JSON.stringify(product));
        console.log(data, product);
        tempProduct = [...product];
        $(".cart").html("");
        tempProduct.map((item, index) => {
          const subtotal = (item.price * item.quantity) + "";
          const html = $("<html>").append(
            $("<tr>", { id: "cart-"+item.product_attribute_id}).append(
              $("<td>").append(
                $("<div>", { class: "thumb_cart" }).append(
                  $("<img>", { src: item.linkImage, width: 50 })
                ),
              ),
              $("<td>").append(
                $("<a>", { class: "item_cart", href: item.url }).append(item.name)
              ),
              $("<td>").append(
                $("<pre>", { class: "mb-0" }).append(item.name_attribute)
              ),
              $("<td>").append(
                $("<strong>").append(item.price.replace(/\B(?=(\d{3})+(?!\d))/g, ',')),
                $("<strong>").append("₫")
              ),
              $("<td>").append(
                $("<div>", { class: "input-number" }).append(
                  $("<input>", { class: "number" ,type: "number", value: item.quantity, min: 1, max: item.maxQuantily, step: 1, "data-price": item.price, "data-index": index })
                )
              ),
              $("<td>").append(
                $("<strong>", { class: "cart-"+ index }).append(subtotal.replace(/\B(?=(\d{3})+(?!\d))/g, ',')),
                $("<strong>").append("₫")
              ),
              $("<td>", { class: "options" }).append(
                $("<a>", { class: "remove-cart-ship", href: "#", "data-id": item.product_attribute_id }).append(
                  $("<i>", { class: "las la-trash-alt la-lg" })
                )
              )
            )
          ).html();
          $(".cart").append(html);
        });
        body.on("click", ".remove-cart-ship", (e) => {
          let { id } = e.currentTarget.dataset;
          id = parseInt(id);
          $("#cart-" + id).remove();
          product = product.filter(item => {
            if (item.product_attribute_id === id) {
              input["base_total_price"] -= item.total;
              input["item_count"] -= item.quantity;
              input["shipping_cost"] = input["base_total_price"] < 500000 ? (input["base_total_price"] === 0 ? 0 : 35000) : 0;
              input["grand_total"] = input["base_total_price"] < 500000 ? input["base_total_price"] + input["shipping_cost"] : input["base_total_price"];
              baseTotalPrice.text(input["base_total_price"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
              shippingCost.text(input["shipping_cost"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
              grandTotal.text(input["grand_total"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            }
            return item.product_attribute_id !== id;
          });
          if (!product.length) {
            $(".btn-order").attr("disabled", true);
          }
        });

        body.css("overflow", "auto");
        $(".bg-loader").fadeOut();
        const number = $("input[type='number']");
        number.InputSpinner();
        number.on("change", function (e) {
          const {index} = e.target.dataset;
          product[index].quantity = e.target.value;
          product[index].total = product[index].price * e.target.value;

          input["base_total_price"] = 0;
          input["item_count"] = 0;
          product.map(item => {
            input["base_total_price"] += item.total;
            input["item_count"] += parseInt(item.quantity);
          })
          input["shipping_cost"] = input["base_total_price"] < 500000 ? 35000 : 0;
          input["grand_total"] = input["base_total_price"] < 500000 ? input["base_total_price"] + 35000 : input["base_total_price"];
          baseTotalPrice.text(input["base_total_price"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
          shippingCost.text(input["shipping_cost"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
          grandTotal.text(input["grand_total"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

          $(".cart-"+index).text(product[index].total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','))
        })

      }
    })
  </script>
@endsection
