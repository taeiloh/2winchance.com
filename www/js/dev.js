function go_draft(idx, m_idx) {
    if(m_idx!="") {
        location.href = "/draft/?index=" + idx;
    }else{
        alert("로그인 후에 이용가능 합니다.");
    }
}