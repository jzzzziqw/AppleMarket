// 1,234,567,890
function formatNumber(input) {
    let value = input.value;
    value = value.replace(/[^0-9]/g, '');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    input.value = value;
}


// Unselect
var conditionNew = document.getElementById('condition-new');
var conditionUsed = document.getElementById('condition-used');
var clearCondition = document.getElementById('clearCondition');

clearCondition.addEventListener('click', function() {
    conditionNew.checked = false;
    conditionUsed.checked = false;
});

var exchangePossible = document.getElementById('exchange-possible');
var exchangeImpossible = document.getElementById('exchange-impossible');
var clearExchange = document.getElementById('clearExchange');

clearExchange.addEventListener('click', function() {
    exchangePossible.checked = false;
    exchangeImpossible.checked = false;
});

var dealSell = document.getElementById('deal-sell');
var dealBuy = document.getElementById('deal-buy');
var dealFree = document.getElementById('deal-free');
var clearDeal = document.getElementById('clearDeal');

clearDeal.addEventListener('click', function() {
    dealSell.checked = false;
    dealBuy.checked = false;
    dealFree.checked = false;
});


// Check PC or not
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');
}

if (window.matchMedia('(max-width: 767px)').matches) {
    // 부모 요소를 선택합니다.
    var parentElement = document.querySelector('.row.align-items-center.h-m-c');

    // A, B, C 요소를 선택합니다.
    var elementA = document.querySelector('.col-lg-3.col-md-3.col-7');
    var elementB = document.querySelector('.col-lg-5.col-md-7.d-xs-none');
    var elementC = document.querySelector('.col-lg-4.col-md-2.col-5');
    
    // A, C, B 순서로 요소를 이동시킵니다.
    parentElement.appendChild(elementA);
    parentElement.appendChild(elementC);
    parentElement.appendChild(elementB);
}


// Search
function enterSearch() {
    if(event.keyCode == 13){
        myFunction();
    }
}

function myFunction() {
    var x = "http://49.50.161.31";
    var y = document.getElementById("search-input").value;
    window.location.href = x + "/search-result.php?search_keyword=" + y;
}