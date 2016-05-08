var React = require('react');

//M音排行
module.exports = React.createClass({
  render() {
    return (
      <div className='side-parts-panel'>
        <div className='panel-title'>M音本周排行</div>
        <div className='panel-body'>
          <div style={{height: 390+'px'}} className='topchat'>
            <div className='clear'></div>
            <div className='s_h s_h_i_r_h' style={{height:390+'px'}}>
              <div className='s_m_r_c_l c_h_p_c' style={{height:65+'px'}}>
                <a target='_blank' href='http://www.missevan.com/sound/105449'>
                  <img
                    src='http://static.missevan.com/coversmini/201603/26/e7b6a81b6cdada9b68dbf7b8068451df110933.jpg'
                    style={{top:-10+'px'}}/>
                </a>
              </div>
              <div className='s_m_r_c_r' style={{width:215+'px',height:68+'px'}}>
                <div className='s_m_r_c_r_s' style={{height:20+'px',overflow:'hidden',font_size:14+'px'}}>
                  <a target='_blank' href='http://www.missevan.com/sound/105449'
                     title='现代耽美广播剧-《小白杨》第五期'>现代耽美广播剧-《小白杨》第五期</a>
                </div>
                <div className='widgetauthor'>
                  <span style={{color:'#999',position:'relative',top:8+'px'}}>up主 :</span>
                  <a className='share-personage-face fl' href='http://www.missevan.com/78142/sound'
                     target='_blank' style={{color:'#c33',position:'relative',top:8+'px',left:2+'px'}}>
                    陆远 </a>

                </div>
                <div className='s_m_r_c_r_j' style={{background:'#fff'}}>
                  <div className='s_m_r_c_r_j_l'>播放: 5041</div>
                  <div className='s_m_r_c_r_j_r'>弹幕: 101</div>
                </div>
              </div>
            </div>
          </div>
          <div className='clear'></div>
        </div>
      </div>
    );
  }
});
