//https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sort_table
function sortTable(col, elem) {
    var method = ' sortingAsc';
    if (elem.classList.contains('sortingAsc')) {
        method = ' sortingDesc';
    }

    Array.prototype.slice.call(
        document.getElementsByClassName('sortingHeader'))
        .forEach(function(x) {x.classList = 'sortingHeader'});

    elem.classList += method;

    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById('myTable');
    switching = true;
    /*Make a loop that will continue until
     no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        //rows = table.getElementsByTagName('tr');
        rows = table.getElementsByClassName('firstLevelSort');
        /*Loop through all table rows (except the
         first, which contains table headers):*/
        for (i = 0; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
             one from current row and one from the next:*/
            x = rows[i].getElementsByTagName('td')[col];
            y = rows[i + 1].getElementsByTagName('td')[col];
            //check if the two rows should switch place:
            if (method == ' sortingAsc') {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (method == ' sortingDesc') {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
             and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function averageRunKM(elem) {
    var kilometers = document.getElementsByClassName('km');
    var acc = 0;
    for (var i = 0; i < kilometers.length; i++) {
        acc += parseInt(kilometers[i].innerHTML);
    }
    elem.innerHTML = acc / kilometers.length;
}
