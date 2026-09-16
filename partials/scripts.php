<script>
(function () {
  var navToggle = document.getElementById('navToggle');
  var navLinks = document.getElementById('navLinks');

  if (navToggle && navLinks) {
    navToggle.addEventListener('click', function () {
      navLinks.classList.toggle('open');
    });
  }

  var profileBtn = document.getElementById('profileBtn');
  var profileMenu = document.getElementById('profileMenu');

  if (profileBtn && profileMenu) {
    profileBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      profileMenu.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
      if (!profileBtn.contains(e.target)) {
        profileMenu.classList.remove('open');
      }
    });
  }
})();
</script>