<!-- Alert Notification -->
<div id="alertContainer" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 50%;
    max-width: 500px;
    z-index: 1050;
    display: none;
">
    <div id="alertMessage" style="
        padding: 15px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.5); /* Hitam transparan */
        color: #ffffff; /* Warna teks putih */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Border putih transparan */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); /* Efek bayangan */
    ">
        <span id="alertText"></span>
        <button type="button" style="
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            cursor: pointer;
        " onclick="$('#alertContainer').fadeOut();">
            &times;
        </button>
    </div>
</div>
