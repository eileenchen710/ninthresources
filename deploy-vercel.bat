@echo off
echo 正在部署 Komito Co-working HTML Template 到 Vercel...
echo.

REM 检查是否安装了Vercel CLI
vercel --version >nul 2>&1
if %errorlevel% neq 0 (
    echo 正在安装 Vercel CLI...
    npm install -g vercel
)

echo.
echo 请按照以下步骤操作：
echo 1. 如果这是第一次使用，请先登录 Vercel
echo 2. 按照提示配置项目
echo 3. 等待部署完成
echo.

vercel

echo.
echo 部署完成！请访问上面显示的URL查看您的网站。
pause 