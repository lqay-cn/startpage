<!DOCTYPE html>
<? ob_start();?>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="instap">
    <link rel="icon" href="https://tc.lqay.cn/LightPicture/2026/03/5f64e0f0f361e19c.png">
    <title>永久引导页</title>
    <link href="assets/m.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <style>
        .item {
            transition:transform 0.3s ease-in-out,opacity 0.3s ease-in-out
        }
        .item:hover {
            transform:scale(1.05);
            opacity:0.9
        }
        .modal {
            display:none;
            position:fixed;
            z-index:1;
            padding-top:60px;
            left:0;
            top:0;
            width:100%;
            height:100%;
            overflow:auto;
            background-color:rgb(0,0,0);
            background-color:rgba(0,0,0,0.4)
        }
        .modal-content {
            margin:5% auto;
            padding:20px;
            border:1px solid #888;
            width:80%;
            max-width:700px
        }
        .close {
            color:#aaa;
            float:right;
            font-size:28px;
            font-weight:bold
        }
        .close:hover,.close:focus {
            color:black;
            text-decoration:none;
            cursor:pointer
        }
        .web_notice {
            display: none;
        }
        
        /* ========== 页面背景 - 双图层系统 ========== */
        .bg-stage {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            will-change: opacity;
        }
        
        .bg-current {
            opacity: 1;
            z-index: 1;
        }
        
        .bg-next {
            opacity: 0;
            z-index: 2;
        }
        
        /* 背景图创意动画 */
        @keyframes bgFadeOutGlitch {
            0% { opacity: 1; transform: scale(1) rotate(0deg); filter: blur(0px) brightness(1); }
            25% { opacity: 0.9; transform: scale(1.02) rotate(0.5deg); filter: blur(1px) brightness(1.1); }
            50% { opacity: 0.6; transform: scale(1.05) rotate(1deg); filter: blur(3px) brightness(1.2); }
            100% { opacity: 0; transform: scale(1.08) rotate(2deg); filter: blur(6px) brightness(1.3); }
        }
        
        @keyframes bgFadeInElastic {
            0% { opacity: 0; transform: scale(1.1) rotate(-2deg); filter: blur(10px) brightness(0.85); }
            30% { opacity: 0.4; transform: scale(0.98) rotate(0.5deg); filter: blur(3px) brightness(0.95); }
            60% { opacity: 0.8; transform: scale(1.01) rotate(-0.2deg); filter: blur(1px) brightness(1.02); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); filter: blur(0px) brightness(1); }
        }
        
        .layer-animate-out { animation: bgFadeOutGlitch 0.9s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; }
        .layer-animate-in { animation: bgFadeInElastic 0.9s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards !important; }
        
        /* ========== Banner 区域 - 修复图片溢出问题 ========== */
        .header {
            position: relative;
            z-index: 5;
        }
        
        /* 外层容器负责定位和头像空间，overflow: visible 让头像显示 */
        .banner-container {
            position: relative;
            width: 100%;
            height: 158px;
            margin-top: 15px;
            margin-bottom: 60px;
            border-radius: 16px;
            overflow: visible;  /* 让头像不被裁剪 */
        }
        
        /* 图片层容器 - 负责裁剪和滑动动画 */
        .banner-layers {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 16px;
            overflow: hidden;  /* 关键：这里裁剪图片，防止图片溢出到容器外 */
            z-index: 1;
        }
        
        .banner-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: 50%;
            background-repeat: no-repeat;
            will-change: transform, opacity;
        }
        
        .banner-current {
            opacity: 1;
            z-index: 1;
            transform: translateX(0%);
        }
        
        .banner-next {
            opacity: 1;
            z-index: 2;
            transform: translateX(100%);
        }
        
        /* 图片从左往右滑动 */
        @keyframes bannerSlideLeftToRight_out {
            0% { transform: translateX(0%); opacity: 1; }
            100% { transform: translateX(100%); opacity: 0; }
        }
        
        @keyframes bannerSlideLeftToRight_in {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0%); opacity: 1; }
        }
        
        /* 图片从右往左滑动 */
        @keyframes bannerSlideRightToLeft_out {
            0% { transform: translateX(0%); opacity: 1; }
            100% { transform: translateX(-100%); opacity: 0; }
        }
        
        @keyframes bannerSlideRightToLeft_in {
            0% { transform: translateX(100%); opacity: 0; }
            100% { transform: translateX(0%); opacity: 1; }
        }
        
        .banner-slide-ltr-out { animation: bannerSlideLeftToRight_out 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; }
        .banner-slide-ltr-in { animation: bannerSlideLeftToRight_in 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; }
        .banner-slide-rtl-out { animation: bannerSlideRightToLeft_out 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; }
        .banner-slide-rtl-in { animation: bannerSlideRightToLeft_in 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards !important; }
        
        /* 光效扫过效果 */
        @keyframes bannerGlow {
            0% { opacity: 0; transform: translateX(-100%); }
            20% { opacity: 0.5; }
            100% { opacity: 0; transform: translateX(100%); }
        }
        
        .banner-glow::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 3;
            background: linear-gradient(90deg, transparent, rgba(255, 245, 200, 0.5), transparent);
            animation: bannerGlow 0.5s ease-out forwards;
            border-radius: 16px;
        }
        
        /* 头像样式 - 放在最上层 */
        .logo {
            position: absolute;
            left: 50%;
            bottom: -50px;
            width: 100px;
            height: 100px;
            background-repeat: no-repeat;
            background-size: contain;
            margin-left: -50px;
            border: 5px solid #fff;
            border-radius: 50%;
            box-shadow: 0 10px 20px 5px #e6e8ea;
            z-index: 20;
            background-color: #fff;
        }
        .logo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        #app {
            background-color: rgba(244, 246, 248, 0.92);
            position: relative;
            z-index: 1;
        }
        
        body {
            margin: 0;
            padding: 0;
            background: transparent;
        }
        
        .author-name {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            line-height: 36px;
            font-weight: 500;
            margin-top: 55px;
            position: relative;
            z-index: 5;
        }
        .desc {
            text-align: center;
            position: relative;
            z-index: 5;
            margin-top: 4px;
        }
        
        .body {
            position: relative;
            z-index: 5;
        }
        
        /* 导航标签 - 只有两个 */
        .tab-list {
            width: 100%;
            padding: 0 20px;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            justify-content: flex-start;
        }
        .tab-item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            height: 35px;
            padding: 0 12px;
            width: 48%;
            background: #fff;
            border-radius: 17px;
            font-size: 14px;
            line-height: 20px;
            margin-right: 10px;
            cursor: pointer;
        }
        .tab-item:last-child {
            margin-right: 0;
        }
        .tab-item .text {
            margin-left: 6px
        }
        .tab-item:before {
            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            background-size: contain;
            background-position: 50%;
            background-repeat: no-repeat
        }
        .lx:before {
            background-image: url(../assets/lx.png)
        }
        .zy:before {
            background-image: url(../assets/zy.png)
        }
        
        /* 应用列表样式 */
        .app-list {
            width: 100%;
            background: #f4f6f8;
            padding: 12px;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            display: flex;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        
        .item {
            width: 50%;
            padding: 8px;
            position: relative;
            color: #222;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            text-decoration: none;
            cursor: pointer;
            box-sizing: border-box;
        }
        
        .content-wrap {
            width: 100%;
            background: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 14px 16px;
            border-radius: 17px;
        }
        
        .img-wrap {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            width: 45px;
            height: 45px;
            margin-right: 10px;
        }
        
        .img-wrap img {
            width: 100%;
            height: 100%;
            -o-object-fit: contain;
            object-fit: contain;
            border-radius: 12px;
        }
        
        .app-name {
            font-size: 15px;
            line-height: 20px;
            width: 100%;
            word-break: break-all;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            font-family: PingFang SC;
            font-weight: 500;
        }
        
        .app-sub {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <!-- 页面背景双图层 -->
    <div class="bg-stage">
        <div class="bg-layer bg-current" id="bgLayer1"></div>
        <div class="bg-layer bg-next" id="bgLayer2"></div>
    </div>
    
    <div id="app">
        <div class="header">
            <div class="banner-container" id="bannerContainer">
                <!-- 图片层用独立的容器，设置 overflow:hidden 裁剪溢出 -->
                <div class="banner-layers" id="bannerLayers">
                    <div class="banner-layer banner-current" id="bannerLayer1"></div>
                    <div class="banner-layer banner-next" id="bannerLayer2"></div>
                </div>
                <div class="logo">
                    <img src="/photos/TX.jpg" alt="">
                </div>
            </div>
            <div class="author-name">引导页</div>
            <p class="desc">永久引导页</p>
        </div>
        <div class="body">
            <div class="tab-list">
                <div class="tab-item zy">
                    <span class="text">导航</span>
                </div>
                <div class="tab-item lx">
                    <span class="text">联系</span>
                </div>
            </div>
            <!-- 应用列表1 - 导航 -->
            <div class="app-list a1">
                <a href="https://me.lqay.cn" class="item" target="_blank" ><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻413.jpg" alt=""></div><p class="app-name">个人主页</p></div></a>
                
                <a href="https://blog.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻1048.jpg" alt=""></div><p class="app-name">个人博客</p></div></a>
                
                <a href="https://dh.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻1014.jpg" alt=""></div><p class="app-name">导航网站</p></div></a>
                
                <a href="https://cookie.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻1086.jpg" alt=""></div><p class="app-name">MC小号</p></div></a>
                
                <a href="https://i.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻575.jpg" alt=""></div><p class="app-name">短网址生成器</p></div></a>
                
                <a href="https://apiv2.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻566.jpeg" alt=""></div><p class="app-name">免费API(99%)</p></div></a>
                
                <a href="https://tc.lqay.cn" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻748.jpg" alt=""></div><p class="app-name">图床(进群可使用)</p></div></a>
                
                <a href="https://vps.lqay.cc.cd" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻960.jpg" alt=""></div><p class="app-name">服务器监控面板</p></div></a>
                
                <a href="https://gallery.lqay.cn/" class="item" target="_blank"><div class="content-wrap"><div class="img-wrap"><img src="https://cdn.jsdmirror.com/gh/lqay-cn/cdn@main/img/zx/f/真寻216.jpg" alt=""></div><p class="app-name">画廊</p></div></a>
            </div>
            <!-- 应用列表2 - 联系 -->
            <div class="app-list a2">
                <a href="javascript:void(0);" class="item" onclick="showModal('/photos/QQ.jpg')">
                    <div class="content-wrap">
                        <div class="img-wrap"><img src="/photos/QQ图标.png" alt=""></div>
                        <p class="app-name">我的QQ</p>
                    </div>
                </a>
                <!-- QQ群 - 图标改成和QQ一样的图片结构 -->
                <a href="https://qm.qq.com/q/RtC6VXxpCu" class="item" target="_blank">
                    <div class="content-wrap">
                        <div class="img-wrap"><img src="/photos/QQ图标.png" alt="QQ群"></div>
                        <div>
                            <p class="app-name">流欺交流群</p>
                            <span class="app-sub">950348367</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Image" style="width:100%">
        </div>
    </div>
    
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $(".a1").css("display", "flex");
            $(".a2").css("display", "none");
            $(".zy").click(function() { 
                $(".a1").css("display", "flex"); 
                $(".a2").css("display", "none"); 
            });
            $(".lx").click(function() { 
                $(".a1").css("display", "none"); 
                $(".a2").css("display", "flex"); 
            });
        });
        
        function showModal(imageSrc) { 
            $("#modalImage").attr("src", imageSrc); 
            $("#myModal").css("display", "block"); 
        }
        $(".close").click(function() { 
            $("#myModal").css("display", "none"); 
        });
        $(window).click(function(event) { 
            if ($(event.target).is("#myModal")) { 
                $("#myModal").css("display", "none"); 
            } 
        });
        
        // ========== 背景图双图层切换 ==========
        (function() {
            const API_BASE = "https://api.lqay.cn/api/zxsjt/?cat=heng";
            const layer1 = document.getElementById('bgLayer1');
            const layer2 = document.getElementById('bgLayer2');
            
            let currentLayer = layer1;
            let nextLayer = layer2;
            let isSwitching = false;
            let preloadedUrl = null;
            let intervalId = null;
            
            function buildUrl() {
                return API_BASE + "&_t=" + Date.now() + "&_rand=" + Math.random().toString(36).substring(2, 10);
            }
            
            function preloadNext() {
                const url = buildUrl();
                const img = new Image();
                img.onload = () => { preloadedUrl = url; };
                img.onerror = () => { preloadedUrl = null; };
                img.src = url;
            }
            
            function performSwitch() {
                if (isSwitching) return;
                if (!preloadedUrl) { setTimeout(performSwitch, 150); return; }
                isSwitching = true;
                
                nextLayer.style.backgroundImage = `url("${preloadedUrl}")`;
                currentLayer.classList.remove('layer-animate-out');
                nextLayer.classList.remove('layer-animate-in');
                void currentLayer.offsetHeight;
                
                currentLayer.classList.add('layer-animate-out');
                nextLayer.classList.add('layer-animate-in');
                nextLayer.style.opacity = '1';
                
                const onAnimationEnd = () => {
                    const temp = currentLayer;
                    currentLayer = nextLayer;
                    nextLayer = temp;
                    nextLayer.style.backgroundImage = '';
                    nextLayer.style.opacity = '0';
                    nextLayer.classList.remove('layer-animate-in', 'layer-animate-out');
                    currentLayer.classList.remove('layer-animate-out', 'layer-animate-in');
                    isSwitching = false;
                    currentLayer.removeEventListener('animationend', onAnimationEnd);
                    nextLayer.removeEventListener('animationend', onAnimationEnd);
                };
                
                currentLayer.addEventListener('animationend', onAnimationEnd, { once: true });
                preloadNext();
            }
            
            const firstUrl = buildUrl();
            const firstImg = new Image();
            firstImg.onload = () => {
                currentLayer.style.backgroundImage = `url("${firstUrl}")`;
                currentLayer.style.opacity = '1';
                nextLayer.style.opacity = '0';
                preloadNext();
                intervalId = setInterval(performSwitch, 5000);
            };
            firstImg.onerror = () => { 
                setTimeout(() => { 
                    const retry = buildUrl(); 
                    new Image().onload = () => { 
                        currentLayer.style.backgroundImage = `url("${retry}")`; 
                        preloadNext(); 
                        intervalId = setInterval(performSwitch, 5000); 
                    }; 
                    new Image().src = retry; 
                }, 1000); 
            };
            firstImg.src = firstUrl;
            
            window.addEventListener('beforeunload', () => { if (intervalId) clearInterval(intervalId); });
        })();
        
        // ========== Banner 双图层切换 - 修复图片溢出 ==========
        (function() {
            const API_BASE = "https://api.lqay.cn/api/zxsjt/?cat=heng";
            const layer1 = document.getElementById('bannerLayer1');
            const layer2 = document.getElementById('bannerLayer2');
            const layersContainer = document.getElementById('bannerLayers');
            
            let currentLayer = layer1;
            let nextLayer = layer2;
            let isSwitching = false;
            let preloadedUrl = null;
            let intervalId = null;
            let slideDirection = 'left-to-right';
            
            function buildUrl() {
                return API_BASE + "&_t=" + Date.now() + "&_rand=" + Math.random().toString(36).substring(2, 10);
            }
            
            function preloadNext() {
                const url = buildUrl();
                const img = new Image();
                img.onload = () => { preloadedUrl = url; };
                img.onerror = () => { preloadedUrl = null; };
                img.src = url;
            }
            
            function performSwitch() {
                if (isSwitching) return;
                if (!preloadedUrl) { setTimeout(performSwitch, 150); return; }
                isSwitching = true;
                
                layersContainer.classList.add('banner-glow');
                setTimeout(() => layersContainer.classList.remove('banner-glow'), 500);
                
                nextLayer.style.backgroundImage = `url("${preloadedUrl}")`;
                nextLayer.style.display = 'block';
                nextLayer.style.opacity = '1';
                
                if (slideDirection === 'left-to-right') {
                    currentLayer.style.transform = 'translateX(0%)';
                    nextLayer.style.transform = 'translateX(-100%)';
                    currentLayer.classList.remove('banner-slide-ltr-out');
                    nextLayer.classList.remove('banner-slide-ltr-in');
                    void currentLayer.offsetHeight;
                    currentLayer.classList.add('banner-slide-ltr-out');
                    nextLayer.classList.add('banner-slide-ltr-in');
                } else {
                    currentLayer.style.transform = 'translateX(0%)';
                    nextLayer.style.transform = 'translateX(100%)';
                    currentLayer.classList.remove('banner-slide-rtl-out');
                    nextLayer.classList.remove('banner-slide-rtl-in');
                    void currentLayer.offsetHeight;
                    currentLayer.classList.add('banner-slide-rtl-out');
                    nextLayer.classList.add('banner-slide-rtl-in');
                }
                
                const onAnimationEnd = () => {
                    const temp = currentLayer;
                    currentLayer = nextLayer;
                    nextLayer = temp;
                    nextLayer.style.backgroundImage = '';
                    nextLayer.classList.remove('banner-slide-ltr-out', 'banner-slide-ltr-in', 'banner-slide-rtl-out', 'banner-slide-rtl-in');
                    currentLayer.classList.remove('banner-slide-ltr-out', 'banner-slide-ltr-in', 'banner-slide-rtl-out', 'banner-slide-rtl-in');
                    currentLayer.style.transform = 'translateX(0%)';
                    currentLayer.style.opacity = '1';
                    nextLayer.style.transform = '';
                    nextLayer.style.opacity = '0';
                    isSwitching = false;
                    currentLayer.removeEventListener('animationend', onAnimationEnd);
                    nextLayer.removeEventListener('animationend', onAnimationEnd);
                    slideDirection = slideDirection === 'left-to-right' ? 'right-to-left' : 'left-to-right';
                };
                
                currentLayer.addEventListener('animationend', onAnimationEnd, { once: true });
                preloadNext();
            }
            
            const firstUrl = buildUrl();
            const firstImg = new Image();
            firstImg.onload = () => {
                currentLayer.style.backgroundImage = `url("${firstUrl}")`;
                currentLayer.style.transform = 'translateX(0%)';
                currentLayer.style.opacity = '1';
                nextLayer.style.opacity = '0';
                preloadNext();
                intervalId = setInterval(performSwitch, 3000);
            };
            firstImg.onerror = () => {
                setTimeout(() => {
                    const retry = buildUrl();
                    new Image().onload = () => {
                        currentLayer.style.backgroundImage = `url("${retry}")`;
                        preloadNext();
                        intervalId = setInterval(performSwitch, 3000);
                    };
                    new Image().src = retry;
                }, 1000);
            };
            firstImg.src = firstUrl;
            
            window.addEventListener('beforeunload', () => { if (intervalId) clearInterval(intervalId); });
        })();
    </script>
    <div id="xf-MusicPlayer" data-cdnName="https://player.xfyun.club/js" data-themeColor="xf-orange" data-songList="12785396384" data-fadeOutAutoplay></div>
    <script src="https://player.xfyun.club/js/xf-MusicPlayer/js/xf-MusicPlayer.min.js"></script>
    <script src="https://player.xfyun.club/js/yinghua.js"></script>
</body>
</html>