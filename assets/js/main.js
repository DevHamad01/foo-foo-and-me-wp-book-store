/**
 * Little Bunny Foo Foo — front-end interactions.
 * Vanilla JS, no dependencies. Each feature initialises only when its markup exists.
 *
 *  1. Navigation & mobile menu      7. Read & listen playlist (home)
 *  2. Reveal on scroll              8. Page-turning book preview
 *  3. Desert scene (parallax+sand)  9. Waveform read-aloud player
 *  4. Hero place slider            10. Activity filters
 *  5. Horizontal rails             11. Contact form & newsletter (AJAX)
 *  6. Journey chapters                12. Loading screen
 *                                     13. Page transitions (fallback)
 *                                     14. Image & video skeletons
 *                                     15. 3D cover tilt + glare
 */
( function () {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var root = document.documentElement;
	var isRTL = root.getAttribute( 'dir' ) === 'rtl';
	var dirSign = isRTL ? -1 : 1; // Horizontal direction of "forward".
	var i18n = ( window.LBFF && window.LBFF.i18n ) || {};
	var $ = function ( sel, ctx ) { return ( ctx || document ).querySelector( sel ); };
	var $$ = function ( sel, ctx ) { return Array.prototype.slice.call( ( ctx || document ).querySelectorAll( sel ) ); };
	var pad = function ( n ) { return ( n < 10 ? '0' : '' ) + n; };
	var fmt = function ( s ) { s = Math.max( 0, Math.floor( s ) ); return pad( Math.floor( s / 60 ) ) + ':' + pad( s % 60 ); };
	var toSec = function ( str ) {
		var p = String( str || '' ).split( ':' ).map( Number );
		return p.length === 3 ? p[ 0 ] * 3600 + p[ 1 ] * 60 + p[ 2 ] : p.length === 2 ? p[ 0 ] * 60 + p[ 1 ] : Number( str ) || 0;
	};

	/* 1. Navigation & mobile menu ---------------------------------------- */
	function initNav() {
		var nav = $( '[data-nav]' );
		var menu = $( '[data-menu]' );
		var openBtn = $( '[data-menu-open]' );
		if ( ! nav ) { return; }

		// Hide on scroll down, show on scroll up; solid glass after the hero.
		var lastY = window.scrollY;
		var ticking = false;
		window.addEventListener( 'scroll', function () {
			if ( ticking ) { return; }
			ticking = true;
			requestAnimationFrame( function () {
				var y = window.scrollY;
				nav.classList.toggle( 'is-solid', y > window.innerHeight * 0.6 );
				if ( ! document.body.classList.contains( 'ff-menu-open' ) ) {
					nav.classList.toggle( 'is-hidden', y > lastY && y > 240 );
				}
				lastY = y;
				ticking = false;
			} );
		}, { passive: true } );

		if ( ! menu || ! openBtn ) { return; }
		menu.removeAttribute( 'hidden' );
		menu.setAttribute( 'aria-hidden', 'true' );

		var open = function () {
			menu.classList.add( 'is-open' );
			menu.setAttribute( 'aria-hidden', 'false' );
			openBtn.setAttribute( 'aria-expanded', 'true' );
			document.body.classList.add( 'ff-menu-open' );
			var first = $( '.ff-menu__close', menu );
			if ( first ) { setTimeout( function () { first.focus(); }, 50 ); }
		};
		var close = function () {
			menu.classList.remove( 'is-open' );
			menu.setAttribute( 'aria-hidden', 'true' );
			openBtn.setAttribute( 'aria-expanded', 'false' );
			document.body.classList.remove( 'ff-menu-open' );
			openBtn.focus();
		};
		openBtn.addEventListener( 'click', open );
		$$( '[data-menu-close]', menu ).forEach( function ( b ) { b.addEventListener( 'click', close ); } );
		$$( 'a', menu ).forEach( function ( a ) { a.addEventListener( 'click', function () { if ( menu.classList.contains( 'is-open' ) ) { close(); } } ); } );
		document.addEventListener( 'keydown', function ( e ) {
			if ( ! menu.classList.contains( 'is-open' ) ) { return; }
			if ( e.key === 'Escape' ) { close(); }
			if ( e.key === 'Tab' ) { // Keep focus inside the menu.
				var f = $$( 'a, button', menu );
				var firstEl = f[ 0 ], lastEl = f[ f.length - 1 ];
				if ( e.shiftKey && document.activeElement === firstEl ) { e.preventDefault(); lastEl.focus(); }
				else if ( ! e.shiftKey && document.activeElement === lastEl ) { e.preventDefault(); firstEl.focus(); }
			}
		} );
		window.addEventListener( 'resize', function () { if ( window.innerWidth > 960 && menu.classList.contains( 'is-open' ) ) { close(); } } );
	}

	/* 2. Reveal on scroll ------------------------------------------------- */
	function initReveal() {
		var items = $$( '[data-reveal]' );
		if ( ! items.length ) { return; }
		if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
			items.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
			return;
		}
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					io.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 } );
		items.forEach( function ( el ) { io.observe( el ); } );
		// Safety net: never leave content hidden.
		setTimeout( function () { items.forEach( function ( el ) { if ( el.getBoundingClientRect().top < window.innerHeight ) { el.classList.add( 'is-visible' ); } } ); }, 1200 );
	}

	/* 3. Desert scene: parallax, particles, video ------------------------- */
	function initScenes() {
		var scenes = $$( '[data-scene]' );
		if ( ! scenes.length ) { return; }

		var mx = 0, my = 0, tmx = 0, tmy = 0;
		window.addEventListener( 'mousemove', function ( e ) {
			tmx = e.clientX / window.innerWidth - 0.5;
			tmy = e.clientY / window.innerHeight - 0.5;
		}, { passive: true } );

		var states = scenes.map( function ( root ) {
			var video = $( 'video', root );
			if ( video ) {
				video.muted = true;
				video.playbackRate = 0.8;
				var saveData = navigator.connection && navigator.connection.saveData;
				if ( reduceMotion || saveData ) { video.removeAttribute( 'autoplay' ); video.pause(); }
			}
			var canvas = $( '.ff-scene__particles', root );
			var st = {
				root: root, video: video, canvas: canvas, ctx: null, w: 0, h: 0, ps: [], visible: true,
				layers: $$( '[data-depth]', root ), particles: root.hasAttribute( 'data-particles' ) && ! reduceMotion
			};
			if ( canvas && st.particles ) {
				st.ctx = canvas.getContext( '2d' );
				st.resize = function () {
					var r = canvas.getBoundingClientRect(), d = Math.min( window.devicePixelRatio || 1, 2 );
					canvas.width = r.width * d; canvas.height = r.height * d;
					st.w = r.width; st.h = r.height;
					st.ctx.setTransform( d, 0, 0, d, 0, 0 );
				};
				st.resize();
				window.addEventListener( 'resize', st.resize );
				var count = window.innerWidth < 700 ? 45 : 90;
				for ( var i = 0; i < count; i++ ) {
					st.ps.push( { x: Math.random() * st.w, y: st.h * ( 0.45 + Math.random() * 0.55 ), vx: 0.15 + Math.random() * 0.7, r: 0.4 + Math.random() * 1.3, a: 0.1 + Math.random() * 0.45, ph: Math.random() * 6.28 } );
				}
			}
			return st;
		} );

		if ( 'IntersectionObserver' in window ) {
			var io = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					states.forEach( function ( st ) {
						if ( st.root !== entry.target ) { return; }
						st.visible = entry.isIntersecting;
						if ( st.video && ! reduceMotion ) {
							if ( st.visible ) { var p = st.video.play(); if ( p && p.catch ) { p.catch( function () {} ); } }
							else { st.video.pause(); }
						}
					} );
				} );
			}, { rootMargin: '100px' } );
			states.forEach( function ( st ) { io.observe( st.root ); } );
		}

		if ( reduceMotion ) { return; }

		var loop = function () {
			requestAnimationFrame( loop );
			mx += ( tmx - mx ) * 0.04; my += ( tmy - my ) * 0.04;
			states.forEach( function ( st ) {
				if ( ! st.visible ) { return; }
				var rect = st.root.getBoundingClientRect();
				var sy = Math.max( 0, -rect.top );
				st.layers.forEach( function ( el ) {
					var d = parseFloat( el.getAttribute( 'data-depth' ) ) || 0;
					el.style.transform = 'translate3d(' + ( mx * d * -60 ).toFixed( 2 ) + 'px,' + ( sy * d * 0.5 + my * d * -20 ).toFixed( 2 ) + 'px,0) scale(1.04)';
				} );
				if ( ! st.ctx ) { return; }
				st.ctx.clearRect( 0, 0, st.w, st.h );
				for ( var i = 0; i < st.ps.length; i++ ) {
					var p = st.ps[ i ];
					p.x += p.vx + mx * 0.3; p.ph += 0.01;
					var y = p.y + Math.sin( p.ph ) * 6 - sy * 0.2;
					if ( p.x > st.w + 4 ) { p.x = -4; p.y = st.h * ( 0.45 + Math.random() * 0.55 ); }
					if ( p.x < -6 ) { p.x = st.w + 4; }
					st.ctx.fillStyle = 'rgba(250,226,186,' + p.a + ')';
					st.ctx.beginPath(); st.ctx.arc( p.x, y, p.r, 0, 6.283 ); st.ctx.fill();
				}
			} );
		};
		requestAnimationFrame( loop );
	}

	/* 4. Hero place slider ----------------------------------------------- */
	function initHeroSlider() {
		var root = $( '[data-hero-slider]' );
		if ( ! root ) { return; }
		var track = $( '[data-track]', root );
		var bar = $( '[data-progress]', root );
		var count = track.children.length;
		var i = 0, timer;
		var go = function ( n ) {
			i = ( n + count ) % count;
			track.style.transform = 'translateX(' + ( -dirSign * i * 254 ) + 'px)';
			if ( bar ) { bar.style.width = ( ( i + 1 ) / count * 100 ) + '%'; }
		};
		var auto = function () { clearInterval( timer ); if ( ! reduceMotion ) { timer = setInterval( function () { go( i + 1 ); }, 6000 ); } };
		$( '[data-next]', root ).addEventListener( 'click', function () { go( i + 1 ); auto(); } );
		$( '[data-prev]', root ).addEventListener( 'click', function () { go( i - 1 ); auto(); } );
		go( 0 ); auto();
	}

	/* 5. Horizontal rails with arrow buttons ------------------------------ */
	function initRails() {
		$$( '[data-scroller]' ).forEach( function ( root ) {
			var track = $( '[data-scroll-track]', root );
			if ( ! track ) { return; }
			var step = function () { return Math.min( 480, track.clientWidth * 0.8 ); };
			var prev = $( '[data-scroll-prev]', root ), next = $( '[data-scroll-next]', root );
			if ( prev ) { prev.addEventListener( 'click', function () { track.scrollBy( { left: -dirSign * step(), behavior: 'smooth' } ); } ); }
			if ( next ) { next.addEventListener( 'click', function () { track.scrollBy( { left: dirSign * step(), behavior: 'smooth' } ); } ); }
		} );
		enableDragScroll( $$( '.ff-rail' ) );
	}

	// Click-and-drag scrolling for mouse users (touch scrolls natively).
	function enableDragScroll( rails ) {
		rails.forEach( function ( el ) {
			var down = false, startX = 0, startLeft = 0, moved = false;
			el.addEventListener( 'pointerdown', function ( e ) {
				if ( e.pointerType !== 'mouse' || e.button !== 0 ) { return; }
				down = true; moved = false; startX = e.clientX; startLeft = el.scrollLeft;
				el.style.scrollBehavior = 'auto'; el.style.scrollSnapType = 'none'; el.style.cursor = 'grabbing';
			} );
			window.addEventListener( 'pointermove', function ( e ) {
				if ( ! down ) { return; }
				var dx = e.clientX - startX;
				if ( Math.abs( dx ) > 4 ) { moved = true; }
				el.scrollLeft = startLeft - dx;
			} );
			window.addEventListener( 'pointerup', function () {
				if ( ! down ) { return; }
				down = false; el.style.scrollBehavior = ''; el.style.scrollSnapType = ''; el.style.cursor = '';
			} );
			el.addEventListener( 'click', function ( e ) { if ( moved ) { e.preventDefault(); e.stopPropagation(); moved = false; } }, true );
			el.addEventListener( 'dragstart', function ( e ) { e.preventDefault(); } );
		} );
	}

	/* 6. Journey chapters (Meet page) ------------------------------------- */
	function initJourney() {
		var root = $( '[data-journey]' );
		if ( ! root ) { return; }
		var track = $( '[data-j-track]', root );
		var cards = $$( '.ff-chapter', track );
		var tabs = $$( '[data-j-go]', root );
		var current = 0;
		var setActive = function ( n ) {
			current = n;
			tabs.forEach( function ( t, k ) { t.classList.toggle( 'is-active', k === n ); } );
		};
		var go = function ( n ) {
			n = Math.max( 0, Math.min( cards.length - 1, n ) );
			track.scrollTo( { left: cards[ n ].offsetLeft - cards[ 0 ].offsetLeft, behavior: reduceMotion ? 'auto' : 'smooth' } );
			setActive( n );
		};
		tabs.forEach( function ( t ) { t.addEventListener( 'click', function () { go( parseInt( t.getAttribute( 'data-j-go' ), 10 ) ); } ); } );
		$( '[data-j-prev]', root ).addEventListener( 'click', function () { go( current - 1 ); } );
		$( '[data-j-next]', root ).addEventListener( 'click', function () { go( current + 1 ); } );
		var raf;
		track.addEventListener( 'scroll', function () {
			cancelAnimationFrame( raf );
			raf = requestAnimationFrame( function () {
				var w = cards[ 0 ].offsetWidth + 24;
				var sl = Math.abs( track.scrollLeft );
				var n = Math.round( sl / w );
				if ( sl + track.clientWidth >= track.scrollWidth - 4 ) { n = cards.length - 1; }
				if ( n !== current ) { setActive( Math.min( cards.length - 1, n ) ); }
			} );
		}, { passive: true } );
	}

	/* Shared: a player that uses real audio when available, otherwise a demo clock. */
	function createPlayer( opts ) {
		var audio = null, timer = null, pos = 0, playing = false, duration = opts.duration || 0;
		var tick = function () { opts.onTime( pos, duration ); };
		var setSrc = function ( src, dur ) {
			stop();
			pos = 0; duration = dur || 0;
			if ( audio ) { audio.pause(); audio = null; }
			if ( src ) {
				audio = new Audio();
				audio.preload = 'none';
				audio.src = src;
				audio.addEventListener( 'loadedmetadata', function () { if ( isFinite( audio.duration ) ) { duration = audio.duration; tick(); } } );
				audio.addEventListener( 'timeupdate', function () { pos = audio.currentTime; tick(); } );
				audio.addEventListener( 'ended', function () { stop(); pos = 0; tick(); } );
			}
			tick();
		};
		var play = function () {
			playing = true; opts.onState( true );
			if ( audio ) { var p = audio.play(); if ( p && p.catch ) { p.catch( function () { stop(); } ); } return; }
			clearInterval( timer );
			timer = setInterval( function () { pos += 1; if ( pos >= duration ) { pos = 0; stop(); } tick(); }, 1000 );
		};
		var stop = function () {
			playing = false; opts.onState( false );
			clearInterval( timer );
			if ( audio ) { audio.pause(); }
		};
		var seek = function ( ratio ) {
			pos = Math.max( 0, Math.min( 1, ratio ) ) * duration;
			if ( audio && isFinite( audio.duration ) ) { audio.currentTime = pos; }
			tick();
		};
		setSrc( opts.src, opts.duration );
		return { play: play, stop: stop, toggle: function () { if ( playing ) { stop(); } else { play(); } }, setSrc: setSrc, seek: seek };
	}

	/* 7. Read & listen playlist (home) ------------------------------------ */
	function initPlaylist() {
		var root = $( '[data-player]' );
		if ( ! root ) { return; }
		var tracks = $$( '[data-track]', root );
		var btn = $( '[data-play]', root );
		var title = $( '[data-now-title]', root );
		var dur = $( '[data-now-dur]', root );
		var bar = $( '[data-bar]', root );
		var first = tracks[ 0 ];
		var player = createPlayer( {
			src: first ? first.getAttribute( 'data-audio' ) : '',
			duration: first ? toSec( first.getAttribute( 'data-duration' ) ) : 0,
			onTime: function ( pos, total ) { if ( bar ) { bar.style.width = total ? ( pos / total * 100 ) + '%' : '0%'; } },
			onState: function ( on ) {
				btn.classList.toggle( 'is-playing', on );
				btn.setAttribute( 'aria-label', on ? ( i18n.pause || 'Pause' ) : ( i18n.play || 'Play' ) );
			}
		} );
		btn.addEventListener( 'click', player.toggle );
		tracks.forEach( function ( t ) {
			t.addEventListener( 'click', function () {
				tracks.forEach( function ( o ) { o.classList.toggle( 'is-active', o === t ); o.setAttribute( 'aria-pressed', o === t ? 'true' : 'false' ); } );
				title.textContent = t.getAttribute( 'data-title' );
				dur.textContent = t.getAttribute( 'data-duration' );
				player.setSrc( t.getAttribute( 'data-audio' ), toSec( t.getAttribute( 'data-duration' ) ) );
				player.play();
			} );
		} );
	}

	/* 8. Page-turning book preview ---------------------------------------- */
	function initFlipbook() {
		var root = $( '[data-flipbook]' );
		if ( ! root ) { return; }
		var spreads = $$( '[data-spread]', root );
		var tabs = $$( '[data-flip-go]', root );
		var leaf = $( '[data-leaf]', root );
		var num = $( '[data-flip-num]', root );
		var current = 0, busy = false;
		var show = function ( n ) {
			spreads.forEach( function ( s, k ) { s.classList.toggle( 'is-active', k === n ); s.setAttribute( 'aria-hidden', k === n ? 'false' : 'true' ); } );
			tabs.forEach( function ( t, k ) { t.classList.toggle( 'is-active', k === n ); t.setAttribute( 'aria-selected', k === n ? 'true' : 'false' ); } );
			if ( num ) { num.textContent = pad( n + 1 ); }
			current = n;
		};
		var turn = function ( n ) {
			n = ( n + spreads.length ) % spreads.length;
			if ( n === current || busy ) { return; }
			if ( reduceMotion || ! leaf ) { show( n ); return; }
			busy = true;
			var back = n < current;
			leaf.classList.toggle( 'is-back', back );
			leaf.classList.remove( 'is-turning' );
			void leaf.offsetWidth; // Restart the transition.
			leaf.classList.add( 'is-turning' );
			setTimeout( function () { show( n ); }, 380 );
			setTimeout( function () { leaf.classList.remove( 'is-turning', 'is-back' ); busy = false; }, 820 );
		};
		$( '[data-flip-prev]', root ).addEventListener( 'click', function () { turn( current - 1 ); } );
		$( '[data-flip-next]', root ).addEventListener( 'click', function () { turn( current + 1 ); } );
		tabs.forEach( function ( t ) { t.addEventListener( 'click', function () { turn( parseInt( t.getAttribute( 'data-flip-go' ), 10 ) ); } ); } );

		// Swipe on touch screens.
		var sx = null;
		var stage = $( '.ff-flipbook__stage', root );
		stage.addEventListener( 'touchstart', function ( e ) { sx = e.touches[ 0 ].clientX; }, { passive: true } );
		stage.addEventListener( 'touchend', function ( e ) {
			if ( sx === null ) { return; }
			var dx = e.changedTouches[ 0 ].clientX - sx;
			if ( Math.abs( dx ) > 40 ) { turn( current + ( dx < 0 ? 1 : -1 ) ); }
			sx = null;
		} );
		root.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'ArrowRight' ) { turn( current + 1 ); }
			if ( e.key === 'ArrowLeft' ) { turn( current - 1 ); }
		} );
	}

	/* 9. Waveform read-aloud player --------------------------------------- */
	function initWave() {
		var root = $( '[data-wave]' );
		if ( ! root ) { return; }
		var bars = $$( '[data-bars] span', root );
		var elapsed = $( '[data-elapsed]', root );
		var btn = $( '[data-wave-play]', root );
		var label = $( '[data-wave-label]', root );
		var player = createPlayer( {
			src: root.getAttribute( 'data-audio' ),
			duration: parseInt( root.getAttribute( 'data-duration' ), 10 ) || 860,
			onTime: function ( pos, total ) {
				var ratio = total ? pos / total : 0;
				bars.forEach( function ( b, k ) { b.classList.toggle( 'is-done', k / bars.length < ratio ); } );
				if ( elapsed ) { elapsed.textContent = fmt( pos ); }
			},
			onState: function ( on ) {
				btn.classList.toggle( 'is-playing', on );
				if ( label ) { label.textContent = on ? ( i18n.pause || 'Pause' ) : ( i18n.play || 'Play the story' ); }
			}
		} );
		btn.addEventListener( 'click', player.toggle );
		var wave = $( '[data-bars]', root );
		wave.addEventListener( 'click', function ( e ) {
			var r = wave.getBoundingClientRect();
			player.seek( isRTL ? ( r.right - e.clientX ) / r.width : ( e.clientX - r.left ) / r.width );
		} );
	}

	/* 10. Activity filters ------------------------------------------------ */
	function initFilters() {
		$$( '[data-filter-group]' ).forEach( function ( root ) {
			var pills = $$( '[data-filter]', root );
			var items = $$( '.ff-act', root );
			var empty = $( '[data-filter-empty]', root );
			pills.forEach( function ( p ) {
				p.addEventListener( 'click', function () {
					var f = p.getAttribute( 'data-filter' );
					pills.forEach( function ( o ) { o.classList.toggle( 'is-active', o === p ); o.setAttribute( 'aria-pressed', o === p ? 'true' : 'false' ); } );
					var shown = 0;
					items.forEach( function ( it ) {
						var ok = f === 'all' || ( f === 'free' ? it.getAttribute( 'data-free' ) === '1' : it.getAttribute( 'data-age' ) === f );
						it.classList.toggle( 'is-hidden', ! ok );
						it.classList.remove( 'is-entering' );
						if ( ok ) { void it.offsetWidth; it.classList.add( 'is-entering' ); shown++; }
					} );
					if ( empty ) { empty.hidden = shown > 0; }
				} );
			} );
		} );
	}

	/* 11. Contact form & newsletter --------------------------------------- */
	function initForms() {
		// Contact role pills.
		var contact = $( '[data-contact]' );
		if ( contact ) {
			var input = $( '[data-role-input]', contact );
			var roleName = $( '[data-role-name]', contact );
			var pills = $$( '[data-role]', contact );
			pills.forEach( function ( p ) {
				p.addEventListener( 'click', function () {
					pills.forEach( function ( o ) { o.classList.toggle( 'is-active', o === p ); o.setAttribute( 'aria-pressed', o === p ? 'true' : 'false' ); } );
					input.value = p.getAttribute( 'data-role' );
					if ( roleName ) { roleName.textContent = p.getAttribute( 'data-plural' ); }
				} );
			} );
			var reset = $( '[data-contact-reset]', contact );
			if ( reset ) {
				reset.addEventListener( 'click', function () {
					contact.classList.remove( 'is-sent' );
					var f = $( 'form', contact );
					if ( f ) { f.reset(); input.value = pills[ 0 ] ? pills[ 0 ].getAttribute( 'data-role' ) : 'PARENT'; pills.forEach( function ( o, k ) { o.classList.toggle( 'is-active', k === 0 ); } ); }
				} );
			}
		}

		if ( ! window.fetch || ! window.FormData ) { return; }

		$$( '[data-ajax-form]' ).forEach( function ( form ) {
			var type = form.getAttribute( 'data-ajax-form' );
			form.addEventListener( 'submit', function ( e ) {
				e.preventDefault();
				var errorBox = $( '[data-form-error]', form );
				var msgBox = $( '.ff-newsletter__msg', form );
				if ( ! form.checkValidity() ) {
					if ( errorBox ) { errorBox.hidden = false; }
					if ( msgBox ) { msgBox.textContent = form.querySelector( 'input[type=email]' ).validationMessage; }
					var bad = form.querySelector( ':invalid' );
					if ( bad ) { bad.focus(); }
					return;
				}
				var submit = $( '[type=submit]', form );
				var label = $( '[data-submit-label]', form );
				var oldLabel = label ? label.textContent : '';
				if ( submit ) { submit.disabled = true; }
				if ( label ) { label.textContent = i18n.sending || 'Sending…'; }
				if ( errorBox ) { errorBox.hidden = true; }

				fetch( form.getAttribute( 'action' ), { method: 'POST', body: new FormData( form ), credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } } )
					.then( function ( r ) { return r.text(); } )
					.then( function ( txt ) {
						// Tolerate stray PHP notices printed before the JSON on misconfigured hosts.
						try { return JSON.parse( txt ); } catch ( err ) {
							var at = txt.indexOf( '{"success"' );
							return at > -1 ? JSON.parse( txt.slice( at ) ) : null;
						}
					} )
					.then( function ( res ) {
						var msg = res && res.data && res.data.message;
						if ( res && res.success ) {
							if ( type === 'contact' && contact ) {
								contact.classList.add( 'is-sent' );
							} else {
								form.classList.add( 'is-done' );
								if ( msgBox ) { msgBox.textContent = msg || ''; }
							}
						} else {
							if ( errorBox ) { errorBox.textContent = msg || i18n.error; errorBox.hidden = false; }
							if ( msgBox ) { msgBox.textContent = msg || i18n.error; }
						}
					} )
					.catch( function () {
						if ( errorBox ) { errorBox.textContent = i18n.error; errorBox.hidden = false; }
						if ( msgBox ) { msgBox.textContent = i18n.error; }
					} )
					.then( function () {
						if ( submit ) { submit.disabled = false; }
						if ( label ) { label.textContent = oldLabel; }
					} );
			} );
		} );
	}

	/* 12. Loading screen (first page of a visit) --------------------------- */
	function initLoader() {
		var loader = $( '[data-loader]' );
		if ( ! loader || ! root.classList.contains( 'ff-loading' ) ) { return; }
		var start = Date.now();
		var finished = false;
		var finish = function () {
			if ( finished ) { return; }
			finished = true;
			loader.classList.add( 'is-done' );
			setTimeout( function () {
				root.classList.remove( 'ff-loading' );
				try { sessionStorage.setItem( 'lbff_seen', '1' ); } catch ( e ) {}
			}, 950 );
		};
		var whenReady = function () { setTimeout( finish, Math.max( 0, 1500 - ( Date.now() - start ) ) ); };
		if ( document.readyState === 'complete' ) { whenReady(); } else { window.addEventListener( 'load', whenReady ); }
		setTimeout( finish, 4200 ); // Never keep visitors waiting on a slow video.
	}

	/* 13. Page transitions (browsers without native View Transitions) ------- */
	function initTransitions() {
		if ( 'onpagereveal' in window || reduceMotion ) { return; } // Native CSS view transitions handle it.
		if ( root.classList.contains( 'ff-arriving' ) ) {
			requestAnimationFrame( function () {
				root.classList.add( 'ff-arrived' );
				setTimeout( function () { root.classList.remove( 'ff-arriving', 'ff-arrived' ); }, 800 );
			} );
		}
		document.addEventListener( 'click', function ( e ) {
			if ( e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey ) { return; }
			var a = e.target.closest && e.target.closest( 'a[href]' );
			if ( ! a || a.target === '_blank' || a.hasAttribute( 'download' ) ) { return; }
			var url;
			try { url = new URL( a.href, location.href ); } catch ( err ) { return; }
			if ( url.origin !== location.origin || /\/wp-(admin|login)/.test( url.pathname ) || /\.(pdf|zip|jpe?g|png|mp4|mp3)$/i.test( url.pathname ) ) { return; }
			if ( url.pathname === location.pathname && url.search === location.search ) { return; } // Same page / anchors.
			e.preventDefault();
			try { sessionStorage.setItem( 'lbff_nav', '1' ); } catch ( err ) {}
			root.classList.add( 'ff-leaving' );
			setTimeout( function () { location.href = url.href; }, 460 );
		} );
		window.addEventListener( 'pageshow', function ( e ) { if ( e.persisted ) { root.classList.remove( 'ff-leaving', 'ff-arriving', 'ff-arrived' ); } } );
	}

	/* 14. Skeletons: shimmer until images and video are ready -------------- */
	function initSkeletons() {
		$$( '.ff-slot__img, .ff-cover__img' ).forEach( function ( img ) {
			var holder = img.closest( '.ff-slot, .ff-cover__face' );
			var done = function () { img.classList.add( 'is-loaded' ); if ( holder ) { holder.classList.add( 'is-loaded' ); } };
			if ( img.complete && img.naturalWidth ) { done(); } else { img.addEventListener( 'load', done ); img.addEventListener( 'error', done ); }
		} );
		$$( '.ff-scene__video' ).forEach( function ( media ) {
			var ready = function () { media.classList.add( 'is-ready' ); };
			if ( media.tagName === 'VIDEO' ) {
				if ( media.readyState >= 3 ) { ready(); } else { media.addEventListener( 'playing', ready ); media.addEventListener( 'canplay', ready ); }
			} else if ( media.complete ) { ready(); } else { media.addEventListener( 'load', ready ); }
		} );
	}

	/* 15. 3D cover tilt + light glare ------------------------------------- */
	function initCoverTilt() {
		if ( reduceMotion || ! window.matchMedia || ! window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) { return; }
		$$( '.ff-cover' ).forEach( function ( cover ) {
			var raf;
			cover.addEventListener( 'pointerenter', function () { cover.classList.add( 'is-tilting' ); } );
			cover.addEventListener( 'pointermove', function ( e ) {
				cancelAnimationFrame( raf );
				raf = requestAnimationFrame( function () {
					var r = cover.getBoundingClientRect();
					var px = ( e.clientX - r.left ) / r.width - 0.5;
					var py = ( e.clientY - r.top ) / r.height - 0.5;
					cover.style.setProperty( '--ty', ( px * 22 ).toFixed( 2 ) + 'deg' );
					cover.style.setProperty( '--tx', ( -py * 12 ).toFixed( 2 ) + 'deg' );
					cover.style.setProperty( '--gx', ( ( px + 0.5 ) * 100 ).toFixed( 1 ) + '%' );
					cover.style.setProperty( '--gy', ( ( py + 0.5 ) * 100 ).toFixed( 1 ) + '%' );
				} );
			} );
			cover.addEventListener( 'pointerleave', function () {
				cancelAnimationFrame( raf );
				cover.classList.remove( 'is-tilting' );
				[ '--ty', '--tx', '--gx', '--gy' ].forEach( function ( v ) { cover.style.removeProperty( v ); } );
			} );
		} );
	}

	/* Boot ----------------------------------------------------------------- */
	var boot = function () {
		[ initLoader, initTransitions, initSkeletons, initNav, initReveal, initScenes, initHeroSlider, initRails, initJourney, initPlaylist, initFlipbook, initWave, initFilters, initForms, initCoverTilt ].forEach( function ( fn ) {
			try { fn(); } catch ( err ) { if ( window.console ) { console.error( '[Foo Foo]', err ); } }
		} );
	};
	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', boot ); } else { boot(); }
}() );
