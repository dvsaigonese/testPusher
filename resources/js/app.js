import Echo from "laravel-echo";
import "./bootstrap";
window.Echo.private("notifications").listen("UserSessionChanged", (e) => {
    //Bắt lấy kênh notifications
    //nghe event ... và viết hàm xử lí
    //tham số e là event mình nghe

    const notificationElement = document.getElementById("notification");

    //Thêm message vào element
    notificationElement.innerText = e.message;
    //Chỉnh sửa class
    notificationElement.classList.remove("invisible");
    notificationElement.classList.remove("alert-success");
    notificationElement.classList.remove("alert-danger");

    notificationElement.classList.add(`alert-${e.type}`);
});

//echo để bắt event và update ui realtime
//update cái list users
//ngay khi có user mới, hoặc thay đổi tên user,
//hoặc user bị xoá
window.Echo.channel("users")
    .listen("UserCreated", (e) => {
        const usersElement = document.getElementById("users");
        let element = document.createElement("li");

        element.setAttribute("id", e.user.id);
        element.innerText = e.user.name;

        usersElement.appendChild(element);
    })
    .listen("UserDeleted", (e) => {
        const element = document.getElementById(e.user.id);
        element.parentNode.removeChild(element);
    })
    .listen("UserUpdated", (e) => {
        const element = document.getElementById(e.user.id);
        element.innerText = e.user.name;
    });

//echo xử lý game
window.Echo.channel("game")
    .listen("RemainingTimeChanged", (e) => {
        timerElement.innerText = e.time;

        circleElement.classList.add("refresh");
        winnerElement.classList.add("d-none");

        resultElement.innerText = "";
        resultElement.classList.remove("text-success");
        resultElement.classList.remove("text-danger");
    })
    .listen("WinnerNumberGenerated", (e) => {
        circleElement.classList.remove("refresh");

        let winner = e.number;
        winnerElement.innerText = winner;
        winnerElement.classList.remove("d-none");

        let bet = betElement[betElement.selectedIndex].innerText;

        if (bet == winner) {
            resultElement.innerText = "You win.";
            resultElement.classList.add("text-success");
        } else {
            resultElement.innerText = "You lose.";
            resultElement.classList.add("text-danger");
        }
    });

//echo xử lí chat
window.Echo.join("chat")
    .here((users) => {
        // gọi ngay thời điểm ta join vào phòng,
        //trả về tổng số user hiện tại có trong phòng (cả ta)
        users.forEach((user) => {
            let element = document.createElement("li");

            element.setAttribute("id", user.id);
            //thêm dòng này
            element.setAttribute("onclick", `greetUser(${user.id})`);

            element.innerText = user.name;

            usersElement.appendChild(element);
        });
    })
    .joining((user) => {
        // gọi khi có user mới join vào phòng
        let element = document.createElement("li");

        element.setAttribute("id", user.id);
        //thêm dòng này
        element.setAttribute("onclick", `greetUser(${user.id})`);

        element.innerText = user.name;

        usersElement.appendChild(element);
    })
    .leaving((user) => {
        // gọi khi có user rời phòng
        const element = document.getElementById(user.id);
        element.parentNode.removeChild(element);
    })
    .listen("MessageSent", (e) => {
        //lắng nghe event của kênh chat
        const messagesElement = document.getElementById("messages");
        let element = document.createElement("li");

        element.innerText = e.user.name + ": " + e.message;

        messagesElement.appendChild(element);
    });
//echo xử lí tin nhắn 1 người
window.Echo.channel("chat.greet.{{ auth()->user()->id }}").listen(
    "GreetingSent",
    (e) => {
        const messagesElement = document.getElementById("messages");
        console.log(messagesElement);
        let element = document.createElement("li");
        element.innerText = e.message;
        element.classList.add("text-success");

        messagesElement.appendChild(element);
    }
);
