let xmlHttp;

function CreateXMLHttpRequest() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest()
    }
    else if (window.ActiveXObject) {
        // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP")
    }
}

function filterByTopic(topicId, topicName) {
    xmlHttp = CreateXMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            // Cập nhật nội dung danh sách
            document.getElementById("search-result").innerHTML = xmlHttp.responseText;
            // Cập nhật tiêu đề
            const title = topicName ? `List Papers - ${topicName}` : "List Papers";
            document.querySelector(".paper-list-title").innerText = title;
            // Cập nhật active cho dropdown
            const links = document.querySelectorAll(".dropdown-content a");
            links.forEach(link => link.classList.remove("active"));
            const matched = Array.from(links).find(link => link.dataset.id == topicId);
            if (matched) matched.classList.add("active");
        }
    };

    const url = 'index.php?action=filter&topic_id=' + encodeURIComponent(topicId);
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function searchPapers() {
    const keyword = document.getElementById("keyword").value;
    const author = document.getElementById("author").value;
    const conference = document.getElementById("conference").value;
    const topic = document.getElementById("topic").value;

    const url = `index.php?action=search&keyword=${encodeURIComponent(keyword)}&author=${author}&conference=${conference}&topic=${topic}`;
    const xmlHttp = CreateXMLHttpRequest();

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            document.getElementById("search-result").innerHTML = xmlHttp.responseText;
        }
    };

    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}