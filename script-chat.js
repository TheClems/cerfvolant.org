// Script js for the chat.php page
setInterval('load_messages()', 500);
setInterval('load_friends()', 500);

function load_messages(){
    $('#messages-list').load('loadmessage.php?myID=<?php echo $MYID_URL; ?>&recipientID=<?php echo $RECIPIENTID_URL; ?>');
    
}
function load_friends(){
    $('#contacts-bar').load('loadfriends.php');
    
}

var chatContainer = document.getElementById("#messages-list");

    function scrollToBottom() {
  const el = document.getElementById("messages-list");
    el.scrollTop = el.scrollHeight;
}


scrollToBottom()