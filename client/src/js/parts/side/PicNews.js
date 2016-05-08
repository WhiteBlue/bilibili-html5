var React = require('react');

module.exports = React.createClass({
  render() {
    return (
      <div className='side-parts-panel'>
        <div className='panel-title'>推荐活动</div>
        <div className='panel-body'>
          <div className='topchat' style={{height: '360px',padding:'37px 0px 15px',width:'360px'}}>
            <div className='e_m_h_l'>
              <div id='e_m_h_p'>
                <div className='e_m_h_p_b e_m_h_p_b_h'></div>
                <div className='e_m_h_p_b'></div>
                <div className='e_m_h_p_b'></div>
                <div className='e_m_h_p_b'></div>
              </div>


              <div className='e_m_h_l_c c_h_p_c' style={{display: 'block'}}>
                <a target='_blank' href='http://www.bilibili.com/video/av3537292/'>
                  <img
                    src='http://static.missevan.com/links/201601/28b002a0d46500c10a100dbf01b7e491180552.png'/>
                </a>
                <div className='e_m_h_l_t'><a target='_blank'
                                              href='http://www.bilibili.com/video/av3537292/'>《寻找克洛托》动态漫画预告PV</a>
                </div>
                <div className='e_m_h_l_b'></div>
              </div>

              <div className='e_m_h_l_c c_h_p_c' style={{display: 'none'}}>
                <a target='_blank' href='http://m.comicq.cn/'>
                  <img
                    src='http://static.missevan.com/links/201602/5a3b6aad05d78458107f4f6cd90e0c05133611.png'/>
                </a>
                <div className='e_m_h_l_t'><a target='_blank' href='http://m.comicq.cn/'>漫画精选</a></div>
                <div className='e_m_h_l_b'></div>
              </div>

              <div className='e_m_h_l_c c_h_p_c' style={{display: 'none'}}>
                <a target='_blank' href='http://www.missevan.com/albuminfo/87334'>
                  <img
                    src='http://static.missevan.com/links/201601/e5d58bb98924988cae4ba44b27b7e256215933.png'/>
                </a>
                <div className='e_m_h_l_t'><a target='_blank'
                                              href='http://www.missevan.com/albuminfo/87334'>LOL日服语音大集合</a>
                </div>
                <div className='e_m_h_l_b'></div>
              </div>

              <div className='e_m_h_l_c c_h_p_c' style={{display: 'none'}}>
                <a target='_blank' href='http://www.missevan.cn/app'>
                  <img
                    src='http://static.missevan.com/links/201511/32d2648fcd67501fd0d40727b3a29b34101150.png'/>
                </a>
                <div className='e_m_h_l_t'><a target='_blank'
                                              href='http://www.missevan.cn/app'>M站APP——来自二次元的声音</a></div>
                <div className='e_m_h_l_b'></div>
              </div>

            </div>
          </div>
          <div className='clear'></div>
        </div>
      </div>
    );
  }
});
