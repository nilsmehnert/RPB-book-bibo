$(document).ready(function() {
  var getProductHeight = $('.book.active').height();

  $('.books').css({
    height: getProductHeight
  });

  function calcProductHeight() {
    getProductHeight = $('.book.active').height();

    $('.books').css({
      height: getProductHeight
    });
  }

  function animateContentColor(nextItem) {
    var getProductColor = $('.book.active').attr('product-color');

    $('body').css('background-color', getProductColor);

    // $('.title').css({
      // color: getProductColor
    // });

    // $('.btn').css({
      // color: getProductColor
    // });
	if($(nextItem).find(".thumbnail img").length > 0){
		
		var rgb = getAverageRGB($(nextItem).find(".thumbnail img").get(0));
		document.body.style.backgroundColor = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
	}
  }

  var productItem = $('.book'),
    productCurrentItem = productItem.filter('.active');

  $('#next').on('click', function(e) {
    e.preventDefault();

    var nextItem = productCurrentItem.next();

    productCurrentItem.removeClass('active');

    if (nextItem.length) {

      productCurrentItem = nextItem.addClass('active');
    } else {
      productCurrentItem = productItem.first().addClass('active');
    }

    calcProductHeight();
    animateContentColor(nextItem);
  });

  $('#prev').on('click', function(e) {
    e.preventDefault();

    var prevItem = productCurrentItem.prev();

    productCurrentItem.removeClass('active');

    if (prevItem.length) {
      productCurrentItem = prevItem.addClass('active');
    } else {
      productCurrentItem = productItem.last().addClass('active');
    }

    calcProductHeight();
    animateContentColor(prevItem);
  });

  // Ripple
  $('[ripple]').on('click', function(e) {
    var rippleDiv = $('<div class="ripple" />'),
      rippleSize = 60,
      rippleOffset = $(this).offset(),
      rippleY = e.pageY - rippleOffset.top,
      rippleX = e.pageX - rippleOffset.left,
      ripple = $('.ripple');

    rippleDiv.css({
      top: rippleY - (rippleSize / 2),
      left: rippleX - (rippleSize / 2),
      background: $(this).attr("ripple-color")
    }).appendTo($(this));

    window.setTimeout(function() {
      rippleDiv.remove();
    }, 1900);
  });
  
  function getAverageRGB(imgEl) {

    var blockSize = 5, // only visit every 5 pixels
        defaultRGB = {r:0,g:0,b:0}, // for non-supporting envs
        canvas = document.createElement('canvas'),
        context = canvas.getContext && canvas.getContext('2d'),
        data, width, height,
        i = -4,
        length,
        rgb = {r:0,g:0,b:0},
        count = 0;

    if (!context) {
        return defaultRGB;
    }

    height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
    width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

    context.drawImage(imgEl, 0, 0);

    try {
        data = context.getImageData(0, 0, width, height);
    } catch(e) {
        /* security error, img on diff domain */alert('x');
        return defaultRGB;
    }

    length = data.data.length;

    while ( (i += blockSize * 4) < length ) {
        ++count;
        rgb.r += data.data[i];
        rgb.g += data.data[i+1];
        rgb.b += data.data[i+2];
    }

    // ~~ used to floor values
    rgb.r = ~~(rgb.r/count);
    rgb.g = ~~(rgb.g/count);
    rgb.b = ~~(rgb.b/count);

    return rgb;

}
  
});