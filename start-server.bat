@echo off
echo 正在启动 Komito Co-working HTML Template 开发服务器...
echo.
echo 服务器将在 http://localhost:3000 启动
echo 按 Ctrl+C 停止服务器
echo.
npx live-server --port=3000 --open=/Komito%20Pack/Komito/index.html --watch=/Komito%20Pack/Komito
pause 