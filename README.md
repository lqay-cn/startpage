# 永久引导页 - 个人导航站

一个功能丰富、视觉效果出众的个人引导页/导航页，支持动态背景切换、Banner轮播、多标签页导航等功能。

## ✨ 特性

- 🎨 **双图层动态背景** - 背景图自动切换，带有毛刺淡出+弹性淡入的创意动画效果
- 🖼️ **Banner轮播** - 顶部横幅图片自动切换，支持左右滑动动画和光效扫过效果
- 👤 **圆形头像展示** - 头像半悬停在Banner上，视觉效果突出
- 📱 **响应式设计** - 完美适配移动端和PC端
- 🎵 **音乐播放器** - 集成第三方音乐播放组件
- 🌸 **樱花飘落特效** - 页面装饰效果，增加视觉趣味
- 🔄 **双标签页切换** - 支持"导航"和"联系"两个内容区域切换

## 🛠️ 技术栈

- HTML5 / CSS3
- JavaScript (原生 + jQuery)
- 第三方API集成

## 📁 项目结构
├── index.php # 主页面文件

├── assets/ # 静态资源目录

│ ├── m.css # 样式文件

│ ├── style.css # 主样式文件

│ ├── lx.png # 联系标签图标

│ └── zy.png # 导航标签图标

└── photos/ # 图片资源目录

├── TX.jpg # 头像图片

├── QQ.jpg # QQ二维码

└── QQ图标.png # QQ图标
## 🚀 快速开始

部署到服务器
直接将项目文件上传到您的网站根目录即可。

⚙️ 配置说明
修改个人信息
在 index.php 中找到以下部分进行修改：
```bash
<!-- 修改作者名称 -->
<div class="author-name">引导页</div>

<!-- 修改头像图片路径 -->
<div class="logo">
    <img src="/photos/TX.jpg" alt="">
</div>
修改导航链接
在 .app-list.a1 区域修改或添加导航项：

<a href="你的链接" class="item" target="_blank">
    <div class="content-wrap">
        <div class="img-wrap">
            <img src="图片地址" alt="">
        </div>
        <p class="app-name">项目名称</p>
    </div>
</a>
修改联系信息
在 .app-list.a2 区域修改联系方式：

<!-- QQ号点击显示二维码 -->
<a href="javascript:void(0);" class="item" onclick="showModal('/photos/QQ.jpg')">
    ...
</a>

<!-- QQ群链接 -->
<a href="QQ群链接" class="item" target="_blank">
    ...
</a>
API配置
项目使用了以下API接口（可根据需要替换）：

用途	API地址
背景图片	https://api.lqay.cn/api/zxsjt/?cat=heng
Banner图片	https://api.lqay.cn/api/zxsjt/?cat=heng
如需更换图片源，请修改JavaScript中的 API_BASE 变量。

📱 功能说明
背景图切换
每5秒自动切换一次

带有毛刺淡出+弹性淡入动画

双图层预加载机制，切换流畅

Banner轮播
每3秒自动切换一次

支持左右方向交替滑动

切换时带有光效扫过效果

标签页切换
导航：展示个人项目/网站链接

联系：展示QQ和QQ群联系方式

🤝 贡献
欢迎提交 Issue 和 Pull Request！

📄 许可证
MIT

🙏 致谢
音乐播放器由 小枫音乐播放器 提供

图片API由 lqay.cn 提供

📧 联系方式
如有问题或建议，欢迎联系：

个人主页：https://me.lqay.cn

博客：https://blog.lqay.cn

⭐ 如果这个项目对你有帮助，欢迎点个Star！
