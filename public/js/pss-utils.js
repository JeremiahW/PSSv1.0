const SERVER_ROOT = "http://localhost:8080/PSS/PSSv1.0/public/index.php/";
const IMAGE_ROOT = "http://localhost:8080/PSS/PSSv1.0/";


//将form中的值转换为键值对。
function getFormJson(frm) {
    var o = {};
    var a = $(frm).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });

    return o;
}

//将Timestamp转换为DateTime字符串
function getLocalTime(value) {
    return new Date(parseInt(value) * 1000).toLocaleString();
}


// To set it up as a global function:
function formatMoney(number, places, symbol, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : "$";
    thousand = thousand || ",";
    decimal = decimal || ".";
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}

function stateFormatter(value, row, index) {
    if(value == "0"){
        return "启用"
    }
    else{
        return "停用"
    }
}

function rowStyle(row, index) {
    //  var classes = ['active', 'success', 'info', 'warning', 'danger'];

    console.log(row.is_deleted);
    if(row.is_deleted===1){
        return {
            classes: "danger"
        };
    }
    return {};

}


