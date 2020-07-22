// Slideshow -----------------------------------------------------------------------------
const AnimationSlide = (array, parent, status) => {
  let direction = "left";
  if (status === "afterChange" && parent.find(".container").hasClass("text-right")) {
    direction = "right";
  }
  array.map((element, index) => {
    switch (status) {
      case "afterChange":
        anime({
          targets: parent.find(element)[0],
          [direction]: ["10%", "0%"],
          opacity: ["0", "1"],
          easing: "easeInOutQuad",
          duration: 600,
          delay: index * 50
        });
        break;
      case "beforeChange":
        parent.find(element).removeAttr("style");
        break;
    }
  });
};
$(".slide-show").slick({
  dots: true,
  infinite: true,
  speed: 300,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 2000,
}).on("beforeChange", () => {
  AnimationSlide(["h2", "p", ".btn"], $(".slick-current .cover"), "beforeChange");
}).on("afterChange", () => {
  AnimationSlide(["h2", "p", ".btn"], $(".slick-current .cover"), "afterChange");
});
AnimationSlide(["h2", "p", ".btn"], $(".slick-current .cover"), "afterChange");

// Slide Product --------------------------------------------------------------------------

$(".action-slide").slick({
  infinite: false,
  dots: false,
  arrows: false,
  slidesToShow: 5,
  responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 4
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 550,
      settings: {
        slidesToShow: 1
      }
    }
  ]
});

$(".slide-brand").slick({
  centerMode: true,
  dots: false,
  infinite: true,
  arrows: false,
  autoplay: true,
  autoplaySpeed: 2000,
  slidesToShow: 8,
  responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 6
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 4
      }
    },
    {
      breakpoint: 550,
      settings: {
        slidesToShow: 2
      }
    }
  ]
});

$(".dropdown").click((e) => {
  return $(e).toggleClass("hover");
});

$(".slide-detail")
  .slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: ".slider-nav"
  })
  .magnificPopup({
    delegate: "a",
    type: "image",
    gallery:{
      enabled: true
    }
  });
$(".slider-nav").slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: ".slide-detail",
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  infinite: true,
  autoplay: true,
  autoplaySpeed: 2000,
});

