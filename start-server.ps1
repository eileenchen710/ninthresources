Write-Host "正在启动 Komito Co-working HTML Template 开发服务器..." -ForegroundColor Green
Write-Host ""
Write-Host "服务器将在 http://localhost:3000 启动" -ForegroundColor Yellow
Write-Host "按 Ctrl+C 停止服务器" -ForegroundColor Yellow
Write-Host ""

try {
    npx live-server --port=3000 --open="/Komito Pack/Komito/index.html" --watch="/Komito Pack/Komito"
} catch {
    Write-Host "服务器启动失败: $($_.Exception.Message)" -ForegroundColor Red
    Read-Host "按任意键退出"
} 