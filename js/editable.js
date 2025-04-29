$(function () {
  $(".bg-editable").click(function () {
    let tid = $(this).prop("id");
    let rid = tid.split("--");
    let tb = rid[0];
    let field = rid[1];
    let where_id = rid[2] ?? "id";
    let where_value = rid[3];
    let may_null = rid[4] ?? "";
    let val = $(this).text();
    console.log(
      `tb: ${tb}\nfield: ${field}\nwhere_id: ${where_id}\nwhere_value: ${where_value}\nval: ${val}\nmayNull: ${may_null},`
    );
    if (!tb || !field || !where_id || !where_value) {
      console.log(
        `tb: ${tb}\nfield: ${field}\nwhere_value: ${where_value}\nval: ${val}\nmayNull: ${may_null},`
      );
      alert(`incomplete variables, lihat pada console!`);
      return;
    }

    let new_value = prompt("Input baru:", val);
    console.log(new_value);

    if (new_value === null || new_value === val) {
      return;
    }

    let link_ajax =
      "ajax/ajax_editable.php" +
      `?tb=${tb}` +
      `&field=${field}` +
      `&new_value=${new_value}` +
      `&where_id=${where_id}` +
      `&where_value=${where_value}` +
      `&may_null=${may_null}` +
      "";
    $.ajax({
      url: link_ajax,
      success: function (a) {
        if (a == "OK") {
          $("#" + tid).text(new_value);
          if (field == where_id) {
            location.reload(); // jika yang diubah adalah primary key
          }
        } else {
          alert(a);
        }
      },
    });
  });
});
