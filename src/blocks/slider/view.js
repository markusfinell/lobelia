import Flickity from "flickity";

document.querySelectorAll(".wp-block-lobelia-slider").forEach((el) => {
  const flkty = new Flickity(el, {
    cellAlign: "center",
    pageDots: false,
    wrapAround: true,
  });
});
