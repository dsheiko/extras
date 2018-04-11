(function(){

  const data = {
    "Dsheiko\\Extras\\Arrays": {
      js: [
        "assign",
        "concat",
        "copyWithin",
        "each",
        "entries",
        "every",
        "fill",
        "filter",
        "find",
        "from",
        "hasOwnProperty",
        "includes",
        "indexOf",
        "is",
        "join",
        "keys",
        "lastIndexOf",
        "map",
        "of",
        "pop",
        "push",
        "reduceRight",
        "reduce",
        "reverse",
        "shift",
        "slice",
        "some",
        "sort",
        "splice",
        "unshift",
        "values"
      ],
      _: [
        "each",
        "map",
        "reduce",
        "reduceRight",
        "find",
        "filter",
        "where",
        "findWhere",
        "reject",
        "every",
        "some",
        "contains",
        "invoke",
        "pluck",
        "max",
        "min",
        "sortBy",
        "groupBy",
        "indexBy",
        "countBy",
        "shuffle",
        "sample",
        "toArray",
        "size",
        "partition",
        "first",
        "initial",
        "last",
        "rest",
        "compact",
        "flatten",
        "without",
        "union",
        "intersection",
        "difference",
        "uniq",
        "zip",
        "unzip",
        "object",
        "indexOf",
        "lastIndexOf",
        "sortedIndex",
        "findIndex",
        "findLastIndex",
        "range",
        "keys",
        "allKeys",
        "values",
        "mapObject",
        "pairs",
        "invert",
        "findKey",
        "extend",
        "pick",
        "omit",
        "defaults",
        "tap",
        "has",
        "property",
        "propertyOf",
        "matcher",
        "isEqual",
        "isMatch",
        "isEmpty",
        "isArray",
        "isObject"
      ]
    },

    "Dsheiko\\Extras\\Collections": {
      _: [
        "chain",
        "each",
        "toArray"
      ]
    },

    "Dsheiko\\Extras\\Functions": {
      js: [
        "apply",
        "bind",
        "call",
        "toString"
      ],

      _: [
        "bind",
        "bindAll",
        "partial",
        "memoize",
        "delay",
        "throttle",
        "debounce",
        "once",
        "after",
        "before",
        "wrap",
        "negate",
        "compose",
        "times",
        "chain"
      ]
    },

    "Dsheiko\\Extras\\Strings": {
      js: [
        "charAt",
        "charCodeAt",
        "concat",
        "endsWith",
        "fromCharCode",
        "includes",
        "indexOf",
        "lastIndexOf",
        "localeCompare",
        "match",
        "padEnd",
        "padStart",
        "remove",
        "repeat",
        "replace",
        "slice",
        "split",
        "startsWith",
        "substr",
        "substring",
        "toLowerCase",
        "toUpperCase",
        "trim"
      ],

      _: [
        "escape",
        "unescape",
        "chain"
      ]
    },

    "Dsheiko\\Extras\\Numbers": {
      js: [
        "isFinite",
        "isInteger",
        "isNaN",
        "parseFloat",
        "parseInt",
        "toFixed",
        "toPrecision"
      ],
      _: [
        "isNumber",
        "chain"
      ]

    },

    "Dsheiko\\Extras\\Booleans": {
      _: [
        "isBoolean",
        "chain"
      ]

    },

    "Dsheiko\\Extras\\Type\\PlainObject": {
      js: [
        "assign",
        "entries",
        "keys",
        "values"
      ],
      _: [

        "keys",
        "values",
        "mapObject",
        "pairs",
        "invert",
        "findKey",
        "pick",
        "omit",
        "defaults",
        "has",
        "isEqual",
        "isEmpty",
        "toArray"
      ]

    },

    "Dsheiko\\Extras\\Any": {

      _: [
        "isDate",
        "isError",
        "isException",
        "isNull",
        "chain"
      ]

    },

    "Chaining": {

      _: [
        "chain",
        "then",
        "tap",
        "value"
      ]

    },

    "Dsheiko\\Extras\\Utils": {

      _: [
      "identity",
      "constant",
      "noop",
      "random",
      "iteratee",
      "uniqueId",
      "now"
      ]

    }



  };


  function debounce(cb, wait, context = null){
    var timer = null;
    return (...args) => {
      clearTimeout( timer );
      timer = setTimeout( () => {
        timer = null;
        cb.apply( context || this, args );
      }, wait );
    };
  }

  function normalizeId(id){
    return id.toLowerCase().replace( /\\/g, "-" );
  }

  function renderSectionList(items, pkg){
    return items.reduce( (carry, item) => {
      const id = normalizeId( `${pkg}-${item}` );
      return carry + `\n<li>- <a href="#${id}">${item}</a></li>`;
    }, "" );
  }

  function getPkgName(pkg){
    const name = pkg.split( "\\" ).pop();
    return name.toLowerCase();
  }

  function renderPkgLabel(title, pkg){
    const id = normalizeId( `${pkg}-${title}` );
    return `<a class="toc_title" href="#${id}">${title}</a>`;
  }

  function renderSection(key, source, pkg){
    if ( !(key in source) ) {
      return "";
    }
    if ( !source[ key ].length ) {
      return "";
    }
    const value = key === "js" ? "JavaScript" : "Underscore.js";
    return `<a class="toc_subtitle">${value} methods</a>
      <ul class="toc_section">`
      + renderSectionList( source[ key ], pkg )
      + `</ul>`;
  }

  function renderMenu(source){
    return Object.keys( source ).reduce( (carry, key) => {
      const pkg = getPkgName( key ),
            inside = renderSection( "js", source[ key ], pkg )
              + renderSection( "_", source[ key ], pkg );

      return carry + ( inside === "" ? "" : renderPkgLabel( key, pkg ) + inside );
    }, "" );
  }

  function filterDataList(list, filter){
    return list.filter( value => {
      return value.indexOf( filter ) !== -1;
    } );
  }

  function filterData(obj, filter){
    return Object.keys( obj ).reduce( (carry, key) => {
      const value = Object.assign( {}, obj[ key ] );
      if ( "js" in value ) {
        value.js = filterDataList( value.js, filter );
      }
      if ( "_" in value ) {
        value._ = filterDataList( value._, filter );
      }
      carry[ key ] = value;
      return carry;
    }, {} );
  }

  function render(source, el){
    el.innerHTML = renderMenu( source );
  }

  const menuEl = document.querySelector( "[data-bind=menu]" ),
    filterEl = document.querySelector( "[data-bind=filter]" ),
    handleFilterInput = function(e){
      render( filterData( data, e.target.value ), menuEl );
    };

  filterEl.addEventListener( "input", debounce( handleFilterInput, 200 ), false );
  render( data, menuEl );


}());