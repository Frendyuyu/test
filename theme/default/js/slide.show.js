/**
 +----------------------------------------------------------
 * 首页幻灯
 +----------------------------------------------------------
 */
var mySwiper = new Swiper ('.swiper-container', {
  direction: 'horizontal', // horizontal：横向切换 vertical：竖向切换
  // effect : 'fade', // 淡入淡出
  loop: true, // 循环模式选项
  autoplay: {
    delay: 5 * 1000, // 自动播放间隔时间5秒
    pauseOnMouseEnter: false, // 鼠标置于swiper时暂停自动切换，鼠标离开时恢复自动切换
    stopOnLastSlide: false, // 当切换到最后一个slide时不停止自动切换（loop模式下无效）
  },
  speed: 2000, // 播放速度

  // 如果需要分页器
  pagination: {
    el: '.swiper-pagination',
    clickable: true, // 分页器可点击
  },

  // 如果需要前进后退按钮
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // 如果需要滚动条
  scrollbar: {
    el: '.swiper-scrollbar',
  },
})