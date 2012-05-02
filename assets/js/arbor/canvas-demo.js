//
// site.js
//
// the arbor.js website
//
(function($){
  // var trace = function(msg){
  //   if (typeof(window)=='undefined' || !window.console) return
  //   var len = arguments.length, args = [];
  //   for (var i=0; i<len; i++) args.push("arguments["+i+"]")
  //   eval("console.log("+args.join(",")+")")
  // }  
  
  var Renderer = function(elt){
    var dom = $(elt)
    var canvas = dom.get(0)
    var ctx = canvas.getContext("2d");
    var gfx = arbor.Graphics(canvas)
    var sys = null

    var _vignette = null
    var selected = null,
        nearest = null,
        _mouseP = null;

    
    var that = {
      init:function(pSystem){
        sys = pSystem
        sys.screen({size:{width:dom.width(), height:dom.height()},
                    padding:[100]})

        $(window).resize(that.resize)
        that.resize()
        that._initMouseHandling()

      },
      resize:function(){
        canvas.width = $(window).width(),
        canvas.height = $(window).height()
        sys.screen({size:{width:canvas.width, height:canvas.height}})
        _vignette = null
        that.redraw()
      },
      redraw:function(){
        gfx.clear()
        sys.eachEdge(function(edge, p1, p2){
          if (edge.source.theUI.alpha * edge.target.theUI.alpha == 0) return
          gfx.line(p1, p2, {stroke:"#363636", width:2, alpha:.0})
		  if (edge.source.theUI.alpha * edge.target.theUI.alpha == 1) return
          gfx.line(p1, p2, {stroke:"#00CCFF", width:2, alpha:.5})
        })
		
		// Cached Images
		var logo = new Image();
		logo.src = "icons/rd_white_reflection.png";
		var Email = new Image();
		Email.src = "icons/envelope_right.png";
        
		sys.eachNode(function(node, pt){
		  var w = Math.max(20, 20+gfx.textWidth(node.name) )
          if (node.theUI.alpha===0) return
		  if (node.theUI.label==='rd'){
			ctx.drawImage(logo, pt.x-w-210, pt.y-w/2); // w = width of the image  
		  }else if (node.theUI.shape=='dot'){
            gfx.oval(pt.x-w/2, pt.y-w/2, w, w, {fill:node.theUI.color, alpha:node.theUI.alpha})
            gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"TradeGothicLTStdLight", size:18})
            gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"TradeGothicLTStdLight", size:18})
          }else if (node.theUI.label==='Email'){
            ctx.drawImage(Email, pt.x-w/2, pt.y-w/2); // w = width of the image
          }else {
            gfx.rect(pt.x-w/2, pt.y-16, w, 30, 8, {fill:node.theUI.color, alpha:node.theUI.alpha})
            gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"TradeGothicLTStdLight", size:16})
            gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"TradeGothicLTStdLight", size:16})
          }
        })
        that._drawVignette()
      },
      
      _drawVignette:function(){
        var w = canvas.width
        var h = canvas.height
        var r = 50

        if (!_vignette){
          var top = ctx.createLinearGradient(0,0,0,r)
          top.addColorStop(0, "white")
          top.addColorStop(1, "rgba(255,255,255,0)")

          var bot = ctx.createLinearGradient(0,h-r,0,h)
          bot.addColorStop(0, "rgba(255,255,255,0)")
          bot.addColorStop(1, "white")

          _vignette = {top:top, bot:bot}
        }
        
        // top
        ctx.fillStyle = _vignette.top
        ctx.fillRect(0,0, w,r)

        // bot
        ctx.fillStyle = _vignette.bot
        ctx.fillRect(0,h-r, w,r)
      },

      
      
      switchSection:function(newSection){
        var parent = sys.getEdgesFrom(newSection)[0].source
        var children = $.map(sys.getEdgesFrom(newSection), function(edge){
          return edge.target
        })
        
        sys.eachNode(function(node){
          if (node.theUI.shape=='dot') return // skip all but leafnodes
		  if (node.theUI.shape=='box') return // skip all but leafnodes

          var nowVisible = ($.inArray(node, children)>=0)
          var newAlpha = (nowVisible) ? 1 : 0
          var dt = (nowVisible) ? .5 : .5
          sys.tweenNode(node, dt, {alpha:newAlpha})

          if (newAlpha==1){
            node.p.x = parent.p.x + .05*Math.random() - .025
            node.p.y = parent.p.y + .05*Math.random() - .025
            node.tempMass = .001
          }
        })
      },
      
      
      _initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        selected = null;
        nearest = null;
        var dragged = null;
        var oldmass = 1

        var _section = null

        var handler = {
          moved:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            nearest = sys.nearest(_mouseP);

            if (!nearest.node) return false

            if (nearest.node.theUI.shape!='dot'){
              selected = (nearest.distance < 50) ? nearest : null
              if (selected){
                 dom.addClass('linkable')
                 window.status = selected.node.theUI.link.replace(/^\//,"http://"+window.location.host+"/").replace(/^#/,'')
              }
              else{
                 dom.removeClass('linkable')
                 window.status = ''
              }
            }else if ($.inArray(nearest.node.name, ['','About','Portfolio','Services','News','Contact']) >=0 ){
              if (nearest.node.name!=_section){
                _section = nearest.node.name
                that.switchSection(_section)
              }
              dom.removeClass('linkable')
              window.status = ''
            }
            
            return false
          },
          clicked:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            nearest = dragged = sys.nearest(_mouseP);
            
            if (nearest && selected && nearest.node===selected.node){
              var link = selected.node.theUI.link
              if (link.match(/^#/)){
                 $(that).trigger({type:"navigate", path:link.substr(1)})
              }else{
                 window.location = link
              }
              return false
            }
            
            
            if (dragged && dragged.node !== null) dragged.node.fixed = true

            $(canvas).unbind('mousemove', handler.moved);
            $(canvas).bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
            var old_nearest = nearest && nearest.node._id
            var pos = $(canvas).offset();
            var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)

            if (!nearest) return
            if (dragged !== null && dragged.node !== null){
              var p = sys.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 1000
            dragged = null;
            // selected = null
            $(canvas).unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            $(canvas).bind('mousemove', handler.moved);
            _mouseP = null
            return false
          }


        }

        $(canvas).mousedown(handler.clicked);
        $(canvas).mousemove(handler.moved);

      }
    }
    
    return that
  }
  
  
  var Nav = function(elt){
    var dom = $(elt)

    var _path = null
    
    var that = {
      init:function(){
        $(window).bind('popstate',that.navigate)
        dom.find('>a').click(that.back)
        $('.more').one('click',that.more)
        
        $('#canvasNav').click(that.reveal)
        that.update()
        return that
      },
      more:function(e){
        $(this).removeAttr('href').addClass('less').html('&nbsp;').siblings().fadeIn()
        $(this).next('h2').find('a').one('click', that.less)
        
        return false
      },
      less:function(e){
        var more = $(this).closest('h2').prev('a')
        $(this).closest('h2').prev('a')
        .nextAll().fadeOut(function(){
          $(more).text('creation & use').removeClass('less').attr('href','#')
        })
        $(this).closest('h2').prev('a').one('click',that.more)
        
        return false
      },
      reveal:function(e){
        $(this).next('dd').fadeToggle('fast')
        return false
      },
      back:function(){
        _path = "/"
        if (window.history && window.history.pushState){
          window.history.pushState({path:_path}, "", _path);
        }
        that.update()
        return false
      },
      navigate:function(e){
        var oldpath = _path
        if (e.type=='navigate'){
          _path = e.path
          if (window.history && window.history.pushState){
             window.history.pushState({path:_path}, "", _path);
          }else{
            that.update()
          }
        }else if (e.type=='popstate'){
          var state = e.originalEvent.state || {}
          _path = state.path || window.location.pathname.replace(/^\//,'')
        }
        if (_path != oldpath) that.update()
      },
      update:function(){
        var dt = 'fast'
        if (_path===null){
          // this is the original page load. don't animate anything just jump
          // to the proper state
          _path = window.location.pathname.replace(/^\//,'')
          dt = 0
          dom.find('p').css('opacity',0).show().fadeTo('slow',1)
        }

        switch (_path){
          case '':
          case '/':
          dom.find('p').text('a graph visualization library using web workers and jQuery')
          dom.find('> a').removeClass('active').attr('href','#')

          $('#docs').fadeTo('fast',0, function(){
            $(this).hide()
            $(that).trigger({type:'mode', mode:'visible', dt:dt})
          })
          document.title = "Raw Designs"
          break
          
          case 'introduction':
          case 'reference':
          $(that).trigger({type:'mode', mode:'hidden', dt:dt})
          dom.find('> p').text(_path)
          dom.find('> a').addClass('active').attr('href','#')
          $('#docs').stop(true).css({opacity:0}).show().delay(333).fadeTo('fast',1)
                    
          $('#docs').find(">div").hide()
          $('#docs').find('#'+_path).show()
          document.title = "Raw Designs » " + _path
          break
        }
        
      }
    }
    return that
  }
  
  $(document).ready(function(){
    var CLR = {
      branch:"#00CCFF",
      About:"#0066FF",
      Portfolio:"#922E00",
      Services:"#a7af00",
	  News:"#a7af00",
	  Contact:"#a7af00"
    }

    var theUI = {
      nodes:{"Raw Designs":{color:"#0099FF", alpha:1, label:'rd'}, 
      
             About:{color:CLR.about, shape:"dot", radius:4, alpha:1, label:'About'}, 
				 Developer:{color:CLR.About, alpha:0, link:'about.html'},
				 HTML5:{color:CLR.About, alpha:0, link:'about.html'},
				 jQuery:{color:CLR.About, alpha:0, link:'about.html'},
			 
			 Portfolio:{color:CLR.branch, shape:"dot", alpha:1, label:'Portfolio'}, 
				 Websites:{color:CLR.Portfolio, alpha:0, link:'portfolio.html'},
				 Sandbox:{color:CLR.Portfolio, alpha:0, link:'portfolio.html'},
			 
			 Services:{color:CLR.branch, shape:"dot", alpha:1, label:'Services'}, 
				 Website:{color:CLR.Services, alpha:0, link:'services.html'},
				 Splash:{color:CLR.Services, alpha:0, link:'services.html'},
				 Mobile:{color:CLR.Services, alpha:0, link:'services.html'},

             News:{color:CLR.branch, shape:"dot", alpha:1, label:'News'}, 
				 Latest:{color:CLR.News, alpha:0, link:'#reference'},
				 Archive:{color:CLR.News, alpha:0, link:'#introduction'},

             Contact:{color:CLR.branch, shape:"dot", alpha:1, label:'Contact'},
				 Email:{color:CLR.Contact, alpha:0, label:'Email', link:'contact.html'},
				 Facebook:{color:CLR.Contact, alpha:0, label:'Facebook', link:'http://facebook.com'},
				 LinkedIn:{color:CLR.Contact, alpha:0, label:'LinkedIn', link:'http://linkedin.com'},
				 Twitter:{color:CLR.Contact, alpha:0, label:'Twitter', link:'http://twitter.com'},
				 Forrst:{color:CLR.Contact, alpha:0, label:'Forrst', link:'http://twitter.com'},
				 Behance:{color:CLR.Contact, alpha:0, label:'Behance', link:'http://twitter.com'},
				 Tumblr:{color:CLR.Contact, alpha:0, label:'Tumblr', link:'http://twitter.com'}
            },
      edges:{
        "Raw Designs":{
          About:{length:.8},
          Portfolio:{length:.8},
          Services:{length:.8},
		  News:{length:.8},
		  Contact:{length:.8}
        },
        About:{Developer:{},
               HTML5:{},
               jQuery:{}
        },
		Portfolio:{Websites:{},
               Sandbox:{}
        },
		Services:{Website:{},
               Splash:{},
               Mobile:{}
        },
        News:{Latest:{},
              Archive:{}
        },
        Contact:{Email:{},
              Facebook:{},
			  LinkedIn:{},
              Twitter:{},
              Forrst:{},
              Behance:{},
              Tumblr:{}
        }
      }
    }


    var sys = arbor.ParticleSystem()
    sys.parameters({stiffness:900, repulsion:2000, gravity:true, dt:0.015, precision:1})
    sys.renderer = Renderer("#viewport")
    sys.graft(theUI)
    
    var nav = Nav("#nav")
    $(sys.renderer).bind('navigate', nav.navigate)
    $(nav).bind('mode', sys.renderer.switchMode)
    nav.init()
  })
})(this.jQuery)