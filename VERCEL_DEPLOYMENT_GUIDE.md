# Vercel 部署指南

## 快速部署步骤

### 方法1：通过 Vercel Dashboard（推荐）

1. **准备代码**
   - 确保代码已推送到 GitHub 仓库
   - 确保 `vercel.json` 文件在项目根目录

2. **访问 Vercel Dashboard**
   - 打开 [https://vercel.com/dashboard](https://vercel.com/dashboard)
   - 点击 "New Project"

3. **导入仓库**
   - 选择您的 GitHub 仓库
   - 点击 "Import"

4. **配置项目设置**
   ```
   Framework Preset: Other
   Root Directory: Komito Pack/Komito
   Build Command: 留空
   Output Directory: .
   Install Command: 留空
   ```

5. **部署**
   - 点击 "Deploy"
   - 等待部署完成

### 方法2：使用 Vercel CLI

```bash
# 安装 Vercel CLI
npm install -g vercel

# 登录 Vercel
vercel login

# 在项目根目录运行
vercel

# 按照提示配置：
# - Set up and deploy: Yes
# - Which scope: 选择您的账户
# - Link to existing project: No
# - Project name: komito-co-working-template
# - In which directory is your code located: Komito Pack/Komito
# - Want to override the settings: No
```

## 故障排除

### 问题1：404 NOT_FOUND

**可能原因：**
- 输出目录配置错误
- 文件路径问题
- 构建配置问题

**解决方案：**

1. **检查 vercel.json 配置**
   ```json
   {
     "version": 2,
     "buildCommand": "echo 'Static HTML - no build required'",
     "outputDirectory": "Komito Pack/Komito"
   }
   ```

2. **在 Vercel Dashboard 中手动设置**
   - 进入项目设置
   - 找到 "Build & Development Settings"
   - 设置 Root Directory 为 `Komito Pack/Komito`
   - 设置 Build Command 为空
   - 设置 Output Directory 为 `.`

3. **检查文件结构**
   ```
   项目根目录/
   ├── vercel.json
   ├── package.json
   └── Komito Pack/
       └── Komito/
           ├── index.html  ← 这个文件必须存在
           ├── assets/
           └── ...
   ```

### 问题2：静态资源加载失败

**解决方案：**
- 确保所有资源路径使用相对路径
- 检查 assets 文件夹是否在正确位置

### 问题3：部署后页面空白

**解决方案：**
1. 检查浏览器控制台错误
2. 确认所有 CSS 和 JS 文件路径正确
3. 检查是否有跨域问题

## 验证部署

部署成功后，您应该能够访问：
- 主页：`https://your-project.vercel.app/`
- 关于页面：`https://your-project.vercel.app/about.html`
- 联系页面：`https://your-project.vercel.app/contact.html`

## 自定义域名

1. 在 Vercel Dashboard 中进入项目设置
2. 找到 "Domains" 部分
3. 添加您的自定义域名
4. 按照提示配置 DNS 记录

## 环境变量

如果需要配置环境变量：
1. 在 Vercel Dashboard 中进入项目设置
2. 找到 "Environment Variables" 部分
3. 添加所需的变量

## 重新部署

如果遇到问题需要重新部署：
1. 在 Vercel Dashboard 中点击 "Redeploy"
2. 或者推送新的代码到 GitHub 仓库（自动触发重新部署）

## 联系支持

如果问题仍然存在：
1. 检查 Vercel 部署日志
2. 查看 Vercel 状态页面
3. 联系 Vercel 支持团队 