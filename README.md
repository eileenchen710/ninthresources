# Komito Co-working HTML Template

这是一个现代化的联合办公空间HTML模板。

## 快速开始

### 安装依赖
```bash
npm install
```

### 启动开发服务器（带热更新）
```bash
npm run dev
```

或者使用其他端口：
```bash
npm run serve
```

### 访问项目
启动后，浏览器会自动打开 `http://localhost:3000` 或 `http://localhost:8080`

## 部署到Vercel

### 方法1：通过Vercel Dashboard
1. 将代码推送到GitHub仓库
2. 访问 [Vercel Dashboard](https://vercel.com/dashboard)
3. 点击 "New Project"
4. 导入您的GitHub仓库
5. 设置项目配置：
   - **Framework Preset**: Other
   - **Root Directory**: 留空（使用根目录）
   - **Build Command**: 留空
   - **Output Directory**: `public`
6. 点击 "Deploy"

### 方法2：使用Vercel CLI
```bash
# 安装Vercel CLI
npm i -g vercel

# 登录Vercel
vercel login

# 部署项目
vercel

# 生产环境部署
vercel --prod
```

### 方法3：一键部署
[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new/clone?repository-url=https://github.com/eileenchen710/ninthresources.git&project-name=komito-co-working-template)

## 项目结构

```
项目根目录/
├── public/              # 部署目录（Vercel输出目录）
│   ├── index.html       # 主页
│   ├── about.html       # 关于页面
│   ├── contact.html     # 联系页面
│   ├── blog.html        # 博客页面
│   └── assets/          # 静态资源
│       ├── css/         # 样式文件
│       ├── js/          # JavaScript文件
│       ├── images/      # 图片资源
│       └── fonts/       # 字体文件
├── Komito Pack/         # 原始模板文件
│   └── Komito/          # 原始文件
└── Doc/                 # 文档
```

## 热更新功能

- 修改任何HTML、CSS或JavaScript文件后，浏览器会自动刷新
- 支持实时预览所有更改
- 无需手动刷新页面

## 可用的页面

- `index.html` - 主页
- `index-2.html` - 主页变体
- `about.html` - 关于我们
- `contact.html` - 联系我们
- `blog.html` - 博客列表
- `team.html` - 团队页面
- `events.html` - 活动页面
- `gallery.html` - 画廊页面

## 技术栈

- HTML5
- CSS3
- JavaScript
- Bootstrap
- jQuery
- Font Awesome
- Owl Carousel

## 部署配置

项目包含 `vercel.json` 配置文件，用于优化Vercel部署：
- 自动设置输出目录为 `public`
- 配置静态资源缓存
- 优化路由设置

## 开发说明

- 所有网站文件都在 `public/` 目录中
- 原始模板文件保留在 `Komito Pack/Komito/` 目录中
- 修改网站时请编辑 `public/` 目录中的文件 