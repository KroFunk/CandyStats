window.onscroll = function() {
    growShrinkMenu()
  };

  function growShrinkMenu() {
    var menu = document.getElementById("menuBar")
    if (document.body.scrollTop > 5 || document.documentElement.scrollTop > 5) {
      menu.className = 'smallMenuBar';
    } else {
      menu.className = 'menuBar';
    }
  }