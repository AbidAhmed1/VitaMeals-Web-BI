const counts = document.querySelectorAll('.count');
const speed = 97;

function isInViewport(element) {
  const rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

counts.forEach((counter) => {
  let animationStarted = false; 

  function upDate() {
    const target = Number(counter.getAttribute('data-target'));
    const count = Number(counter.innerText);
    const inc = Math.ceil(target / speed); // 

    if (count < target) {
      counter.innerText = Math.min(Math.floor(inc + count), target); 
      setTimeout(upDate, 15);
    } else {
      counter.innerText = target;
    }
  }

  function handleScroll() {
    if (isInViewport(counter) && !animationStarted) {
      animationStarted = true;
      upDate();
    }
  }

  if (isInViewport(counter)) {
    animationStarted = true;
    upDate();
  }

  window.addEventListener('scroll', handleScroll);
});

// Ceci est un commentaire sur une seule ligne.


document.querySelector(".search-btn").addEventListener("click", function () {
    var keyword = document.getElementById("search-input").value;
    window.location.href = "liste-patients.php?search=" + encodeURIComponent(keyword);
});
