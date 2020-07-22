<li class="nav-item">
  <div class="dropdown dropdown-cart">
    <a class="nav-link" href="#">
      <i class="las la-shopping-cart"></i>
      <span class="badge badge-primary count-cart">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <ul class="list-unstyled list-cart">
      </ul>
      <div class="total float-left w-100">
        <p><strong>{{__('client.total')}}</strong><span class="total-price">0</span></p>
        <a href="/cart" class="btn btn-warning btn-block btn-checkout disabled">{{__('client.viewCart')}}</a>
      </div>
    </div>
  </div>
</li>
@section("script-cart")
  <script>
    const nameCookie = "shop-hung";
    const addToCart = (nameProduct, linkImage, price, quantity, index, product_attribute_id, url) => {
      const html = $("<html>").append(
        $("<li>", { class: "float-left w-100 cart-product-" + product_attribute_id, "data-quantity": quantity }).append(
          $("<a>", { class: "float-left w-100", href: url }).append(
            $("<img>", { width: 50, height: 50, src: linkImage }),
            $("<span>").text(nameProduct),
            $("<br>"),
            $("<strong>").text(price.replace(/\B(?=(\d{3})+(?!\d))/g, ',') + "₫ x "),
            $("<strong>", { class: "quantity" }).text(quantity)
          ),
          $("<a>", { class: "action", "data-quantity": quantity, "data-price": price, "data-index": index, "data-id": product_attribute_id }).append(
            $("<i>", { class: "las la-trash-alt" })
          )
        )
      ).html();
      $(".list-cart").append(html);
    };

    let product = Cookies.get(nameCookie);
    if (!product) {
      Cookies.set(nameCookie, "[]");
      product = "[]";
    }
    product = JSON.parse(product);
    let countProduct = 0;
    let totalProduct = 0;
    product.map((item, index) => {
      addToCart(
        item.name,
        item.linkImage,
        item.price,
        item.quantity,
        index,
        item.product_attribute_id,
        item.url,
      );
      countProduct += item.quantity;
      totalProduct += item.quantity * item.price;
    });
    const count = $(".count-cart");
    const total = $(".total-price");
    if (totalProduct > 0) {
      $(".btn-checkout").removeClass("disabled");
    }
    count.text(countProduct);
    total.text(totalProduct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + "₫");

    $("body").on("click", ".action", (e) => {
      const count = $(".count-cart");
      let { price, id } = e.currentTarget.dataset;
      let quantity = e.currentTarget.attributes["data-quantity"].value;
      id = parseInt(id);
      quantity = parseInt(quantity);
      price = parseInt(price);
      totalProduct -= price * quantity;

      count.text(parseInt(count[0].outerText) - quantity);
      total.text(totalProduct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + "₫");
      if (totalProduct === 0) $(".btn-checkout").addClass("disabled");
      product = product.filter(item => item.product_attribute_id !== id);
      Cookies.set(nameCookie, JSON.stringify(product));
      $(".cart-product-"+ id).remove();

      const btn = document.getElementById("add-to-cart");
      if (btn.attributes["data-id"].value === id) {
        const input = $("#product-quality");
        input.attr("disabled", false)
        let max = input.attr("max");
        max = parseInt(max)
        if (max > quantity) {
          input.attr("max", max - quantity);
        } else {
          input.attr("max", quantity - max);
        }
        input.val(1)
        btn.disabled = false;
      }
    })

    $("#add-to-cart").click((e) => {
      const quantity = $("#product-quality")
      let numberQuantity = parseInt(quantity.val()) ;
      if (numberQuantity > 0) {
        const item = JSON.parse(e.target.attributes["product"].value);
        const linkImage = $("#image-product").data("src");
        const name = $("#title-product").text();
        const price = !!item.sale_price ? item.sale_price : item.price;

        const priceProduct = numberQuantity * price;
        count.text(parseInt(count[0].outerText) + numberQuantity);
        totalProduct += priceProduct;
        total.text(totalProduct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + "₫");

        let newQuantity = 0;

        product = product.map(data => {
          if (data.product_attribute_id === item.id) {
            newQuantity = data.quantity + numberQuantity;
            data.quantity = newQuantity;
            return data;
          } else {
            return data;
          }
        })
        if (newQuantity === 0) {
          product.push({
            name,
            linkImage,
            price,
            "quantity": numberQuantity,
            "product_attribute_id": item.id,
            "product_id": e.target.dataset.productId,
            "url": e.target.dataset.url,
            name_attribute,
          });
          addToCart(
            name,
            linkImage,
            price,
            numberQuantity,
            product.length - 1,
            item.id,
            e.target.dataset.url,
          );
        } else {
          const target = $(".cart-product-" + item.id);
          target.attr("data-quantity", newQuantity);
          target.find(".quantity").text(newQuantity)
          target.find(".action").attr("data-quantity", newQuantity);

          numberQuantity = newQuantity;
        }
        Cookies.set(nameCookie, JSON.stringify(product));
        $(".btn-checkout").removeClass("disabled");
        e.target.disabled = item.quantity - numberQuantity < 1
        quantity.val(item.quantity - numberQuantity > 0 ? 1 : 0);
        quantity.attr("max", item.quantity - numberQuantity)
      }
    })
  </script>
@endsection
