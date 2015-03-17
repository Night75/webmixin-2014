var svgIconConfig = {
	mail : {
		url : '/bundles/nightdisplay/images/icons/mail.svg',
		animation : [
			{ 
				el : 'path', 
				animProperties : { 
					from : { val : '{"path" : "m 61.693118,24.434001 -59.386236,0 29.692524,19.897984 z"}' }, 
					to : { val : '{"path" : "m 61.693118,24.434001 -59.386236,0 29.692524,-19.7269617 z"}' }
				} 
			}
		]
	},
    smartphone : {
        url : '/bundles/nightdisplay/images/icons/smartphone.svg',
        animation : [
            {
                el : 'path:nth-child(2)',
                animProperties : {
                    from : { val : '{"transform" : "t-10 0 s0 34 18.5"}' },
                    to : { val : '{"transform" : "t0 0 s1 34 18.5", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 34 18.5"}', delayFactor : .5 }
                }
            },
            {
                el : 'path:nth-child(3)',
                animProperties : {
                    from : { val : '{"transform" : "t-10 0 s0 34 18.5"}', delayFactor : .25 },
                    to : { val : '{"transform" : "t0 0 s1 34 18.5", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 34 18.5"}', delayFactor : .25 }
                }
            },
            {
                el : 'path:nth-child(4)',
                animProperties : {
                    from : { val : '{"transform" : "t-10 0 s0 34 18.5"}', delayFactor : .5 },
                    to : { val : '{"transform" : "t0 0 s1 34 18.5", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 34 18.5"}' }
                }
            }
        ]
    },
    map : {
        url : '/bundles/nightdisplay/images/icons/map.svg',
        animation: [
            {
                el: 'path:nth-child(4)',
                animProperties: {
                    from: {val: '{"stroke-dashoffset":0}'},
                    to: {val: '{"stroke-dashoffset":46.1}', before: '{"stroke-dashoffset":0}'}
                }
            }
        ]
    },
    user : {
        url: '/bundles/nightdisplay/images/icons/hi-there.svg'
    }
};