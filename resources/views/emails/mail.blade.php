<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 14px;font-family:Arial, Helvetica, sans-serif;background-color: #222;">
  <tbody>
  <tr>
    <td>
      <table style="width: 600px; margin: 0 auto; border-collapse: collapse;">
        <tbody>
        <tr bgcolor="red">
          <td style="color: white;text-align: center;padding: 1.5rem;">
            <h1>WeSports</h1>
          </td>
        </tr>
        <tr bgcolor="lightgray">
          <td style="text-align: center;padding: 1rem;">
            <h2>Cám ơn bạn đã đặt hàng</h2>
          </td>
        </tr>
        <tr bgcolor="white">
          <td style="padding: 1rem;">
            <table style="width: 100%; border-spacing: 0;">
              <tbody>
              <tr style="vertical-align: top;">
                <td>
                  <h3 style="text-decoration: underline; color: crimson;">Giao tới</h3>
                  <p style="line-height: 1.5;">
                    <strong>{{$order->full_name}}</strong><br>
                    <span>{{$order->phone_number}}</span>
                    <small>{{$order->address}}</small>
                  </p>
                  <p>{{$order->note}}</p>
                </td>
              </tr>
              <tr>
                <td colspan="2"><h2 style="color: crimson;">Danh sách đơn hàng của bạn</h2></td>
              </tr>
              <tr>
                <td colspan="2">
                  <table style="width: 100%; border-spacing: 0;">
                    <thead style="background-color: lightgray;">
                    <tr>
                      <th align="left" style="padding: 0.3rem 0.5rem;">Tên sản phẩm</th>
                      <th>Số Lượng</th>
                      <th>Đơn giá</th>
                      <th align="right" style="padding: 0.3rem 0.5rem;">Tổng cộng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItem as $item)
                      <tr>
                        <td align="left" style="padding: 0.5rem; border-bottom: 1px solid lightgray;border-left: 1px solid lightgray;">
                          <strong>{{$item->name}}</strong><br>
                          <small><pre style="margin: 0;padding: 0;">{{$item->name_attribute}}</pre></small>
                        </td>
                        <td align="center" style="border-bottom: 1px solid lightgray;">{{$item->quantity}}</td>
                        <td align="center" style="border-bottom: 1px solid lightgray;">{{$item->price}}</td>
                        <th align="right" style="padding: 0.5rem; border-bottom: 1px solid lightgray;border-right: 1px solid lightgray;">{{$item->total}}</th>
                      </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th colspan="3" align="right" style="padding: 0.6rem 0.4rem 0.4rem;">Tổng tiền hàng:</th>
                      <th align="right" style="padding: 0.6rem 0.4rem 0.4rem;">{{$order->base_total_price}}</th>
                    </tr>
                    <tr>
                      <th colspan="3" align="right">Phí vận chuyển:</th>
                      <th align="right" style="padding: 0.4rem;">{{$order->shipping_cost}}</th>
                    </tr>
                    <tr>
                      <th colspan="3" align="right">Tổng thanh toán:</th>
                      <th align="right" style="padding: 0.4rem;">{{$order->grand_total}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </td>
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr bgcolor="black" style="border-top: solid 4px crimson;">
          <td>
            <table style="width: 100%; color: lightgray; text-align: center">
              <tbody>
              <tr valign="top">
                <td style="padding: 2rem; width: 50%">
                  Liền Kề 226 No-04 khu A Khu đất dịch vụ yên Nghĩa, Quận Hà Đông, Hà Nội.
                </td>
                <td style="padding: 2rem; width: 50%">
                  +94 423-23-221 <br>
                  cskh@hotro.wesports.vn
                </td>
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr bgcolor="white">
          <td align="center" style="padding: 1rem;">
            &copy; {{date("Y")}} Công ty TNHH Wesports.,
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  </tbody>
</table>
