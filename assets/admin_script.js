
//here we need a local storage to collect all nodes ( it gives an opportunity to delete garbage nodes for admin )

function addItemToLocalStorage(itemName, index) {

    var temp = JSON.parse(localStorage.getItem(index));
    if (temp == '') {
        localStorage.setItem(index, JSON.stringify([]));
        temp.push(itemName);
        var tempItem = JSON.stringify(temp);
        localStorage.setItem(index, tempItem);
    } else {
        temp.push(itemName);
        var tempItem = JSON.stringify(temp);
        localStorage.setItem(index, tempItem);
    }
}

function getItemFromLocalStorage(index) {
    var temp = JSON.parse(localStorage.getItem(index));
    return temp;
}

function initLocalStorage(index) {
    localStorage.setItem(index, JSON.stringify([]));
}

