function copy_url() {
    console.log("=== copy_url ===");
    var copyText = document.getElementById("share_url");
    $("#share_url").show();
    copyText.select();
    document.execCommand("Copy");
    $("#share_url").hide();
    alert("URL이 복사되었습니다.");
}

function go_draft(idx, m_idx) {
    if(m_idx!="") {
        location.href = "/draft/?index=" + idx;
    }else{
        alert("로그인 후에 이용가능 합니다.");
        var url    = "/draft/";
        location.href = '/login/index.php?rtnUrl='+ url;
    }
}

function go_url(url) {
    if (url != undefined && url != "") {
        location.href = url;
    }
}