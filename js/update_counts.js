function update_counts() {
  let total_antrian = parseInt($("#total_antrian").text());
  let nama_page = $("#nama-page").text();
  let p = "total";
  if (nama_page == "display") {
    p = "terlayani";
  }
  $.ajax({
    url: "ajax/ajax_realtime_counts.php?p=" + p,
    success: function (a) {
      new_realtime_counts = parseInt(a);
      console.log(
        `${p}: ${total_antrian}, new_realtime_counts: ${new_realtime_counts}`
      );
      if (total_antrian != new_realtime_counts) {
        // console.log("perlu reload");
        location.reload();
        return;
      }
    },
  });
}

$(function () {
  setInterval(() => {
    update_counts();
  }, 2000);
});
