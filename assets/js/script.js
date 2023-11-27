$(function() {
  $('#datepicker').datepicker();
});

var toggle = document.getElementById("myToggle");
toggle.addEventListener('change', function() {
  if (toggle.checked == true) {
    // mSelect.style.display = "none";
    mSelect.style.opacity = "0%";
    mSelect.disabled = "true";
  }
  else {
    // mSelect.style.display = "block";
    mSelect.style.opacity = "100%";
    mSelect.disabled = "false";
  }
});

$(function() {
  $('.date-own').datepicker({
  minViewMode: 2,
  format: 'yyyy'
})});