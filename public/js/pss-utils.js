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
