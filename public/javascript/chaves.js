function toggleModal(modalID) {
    $("#" + modalID).toggleClass("hidden flex");
    $("#" + modalID + "-backdrop").toggleClass("hidden flex");
}