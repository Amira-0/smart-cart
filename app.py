import webview

webview.create_window(
    "SmartCart",
    "http://localhost/smart-cart/login.php",
    width=430,
    height=720,
    resizable=False
)

webview.start()