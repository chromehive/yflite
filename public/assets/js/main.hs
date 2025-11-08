-- Init
def sendMessage(message)
    WebSocket.send message
end

def parseMessage(message)
    try
        return JSON.parse(message)
    catch error
        return false
end

def appendMessage(message)
    set msgContainer to #messages
    set parsedMsg to parseMessage(message)
    if parsedMsg
        set msgElem to '<div class="bot-inbox inbox msg-{{parsedMsg.type}} mb-2">
            <span class="msg-header">{{parsedMsg.sender}}: </span>
            <span class="msg-text">{{parsedMsg.text}}</span>
        </div>'
        append msgElem to msgContainer     
end

def setup()
    set sender to ''
    set joinForm to .join-form
    set msgForm to .msg-form
    set closeForm to .close-form

    on joinForm submit
        trigger joinForm halt submit
        set sender to #sender's value
        sendMessage JSON.stringify { type: "join", sender: sender, text: sender + ' joined the chat!' }
        add .hidden to joinForm
        remove .hidden from msgForm
        remove .hidden from closeForm

    on msgForm submit
        trigger msgForm halt submit
        set msgField to #message
        set msgText to msgField's value
        sendMessage JSON.stringify { type: "normal", sender: sender, text: msgText }
        set msgField's value to ''

    on closeForm submit
        trigger closeForm halt submit
        WebSocket.close()
        window.location.reload() 
end

-- connect to WebSocket
set socket to WebSocket "ws://localhost:8920"

on socket open
    appendMessage JSON.stringify { type: "join", sender: "Browser", text: "connected to the chat server" }
    setup

on socket message as event
    appendMessage event.data

on socket close as event
    if event.wasClean
        appendMessage JSON.stringify { type: "left", sender: "Browser", text: "The connection closed cleanly" }
    else
        appendMessage JSON.stringify { type: "left", sender: "Browser", text: "The connection closed for some reason" }

on socket error as event
    console.log "WebSocket Error"
    console.log event
