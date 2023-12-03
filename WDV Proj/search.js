// search.js
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("searchInput").addEventListener("input", function () {
        var input, filter, items, i, name;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        items = document.querySelectorAll(".product-item");

        for (i = 0; i < items.length; i++) {
            name = items[i].getElementsByTagName("h3")[0].innerText;

            if (name.toUpperCase().indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    });
});
