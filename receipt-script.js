document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const receiptText = urlParams.get('receiptText');

    if (receiptText) {
        // Display the receipt content on the page
        const receiptDiv = document.getElementById("receipt");
        receiptDiv.innerHTML = `<div>${receiptText}</div>`;
    } 
});
