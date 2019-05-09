// If forum has image, add responsive image and a class to parent
function addForumImageClass() {
	var forumImage = document.querySelectorAll( '.list-inner .forum-image' );

	if ( forumImage && forumImage.length ) {
		for ( var i = 0; i < forumImage.length; i++ ) {
			var fImage = forumImage[i];

			// Add class to parent row
			var parentRow = fImage.parentNode.parentNode.parentNode;
			parentRow.className += ( checkForClasses( parentRow ) + 'has-forum-image' );
		}
	}
}

// Add classes to fieldset dl dd depending on conditions
function addFieldsetClasses() {
	var ddSelector = 'fieldset:not(.polls) dl:not(.pmlist) dd';
	var fieldsetDd = document.querySelectorAll( ddSelector );
	var fieldsetRadio = document.querySelectorAll( ddSelector + ' input[type="radio"]' );

	if ( fieldsetDd && fieldsetDd.length ) {
		for ( var i = 0; i < fieldsetDd.length; i++ ) {
			var dd = fieldsetDd[i];

			// Check if there are multiple children in the dd
			if ( dd.children.length > 1 ) {
				dd.className += ( checkForClasses( dd ) + 'has-multiple-fields' );
			}

			// Check if element has an nbsp space
			if ( dd.innerHTML.indexOf( '&nbsp;' ) !== -1 ) {
				dd.className += ( checkForClasses( dd ) + 'has-space' );
			}
		}
	}

	// Add radio button class to parent elements (labels)
	if ( fieldsetRadio && fieldsetRadio.length ) {
		for ( var i = 0; i < fieldsetRadio.length; i++ ) {
			var radio = fieldsetRadio[i];
			radio.parentNode.className += ( checkForClasses( radio.parentNode ) + 'has-radio-button' );
		}
	}
}

// Add elements for styling checkboxes and radios
function styleFieldElements( selector, typeClass ) {
	var fieldSelector = document.querySelectorAll( selector );

	if ( fieldSelector && fieldSelector.length ) {
		for ( var i = 0; i < fieldSelector.length; i++ ) {
			var field = fieldSelector[i];

			// Create the field wrapper div
			var fieldWrapper = document.createElement( 'span' );
			fieldWrapper.setAttribute( 'class', 'field-wrapper field-wrapper-' + typeClass );

			// Create the inner span
			var fieldBox = document.createElement( 'span' );
			fieldBox.setAttribute( 'class', 'field-box' );

			// Insert wrapper before the field
			field.parentNode.insertBefore( fieldWrapper, field.nextSibling );

			// Append elements to wrapper
			fieldWrapper.appendChild(field);
			fieldWrapper.appendChild(fieldBox);
		}
	}
}

// Add no-pagination class to body to hide pagination
function addNoPaginationClass() {
	var pagination = document.querySelector( '.action-bar .pagination' );

	if ( pagination ) {
		var paginationText = pagination.innerText.toLowerCase();
		var paginationPhrase = 'page 1 of 1';

		if ( paginationText.indexOf( paginationPhrase ) !== -1 ) {
			var regex = new RegExp( paginationPhrase, 'gi' );
			var totalNumber = paginationText.replace( regex, '' ).match( /\d+/g );

			if ( totalNumber && totalNumber <= 0 ) {
				body.className += ( checkForClasses( body ) + 'no-pagination' );
			}
		}
	}
}

// On user profile, check for thanks list content
function addThanksClass() {
	var extraDetailsTitle = document.querySelectorAll( '#viewprofile .extra-details h3' );

	if ( extraDetailsTitle && extraDetailsTitle.length ) {
		for ( var i = 0; i < extraDetailsTitle.length; i++ ) {
			var title = extraDetailsTitle[i];

			if ( title.innerHTML.indexOf( 'Thanks list' ) !== -1 ) {
				// Add class to parent row
				var parentRow = title.parentNode.parentNode;
				parentRow.className += ( checkForClasses( parentRow ) + 'member-thanks-list' );
			}
		}
	}
}

// Format rank and username display on member lists
function moveRankText() {
	var rankImgs = document.querySelectorAll( 'table.table1 .rank-img' );

	if ( rankImgs && rankImgs.length ) {
		for ( var i = 0; i < rankImgs.length; i++ ) {
			var rank = rankImgs[i];

			rank.parentNode.appendChild(rank);

			// Also add "name" class to td elements
			if (rank.parentNode.nodeName == 'TD' || rank.parentNode.nodeName == 'td') {
				rank.parentNode.className += ( checkForClasses( rank.parentNode ) + 'name' );
			}
		}
	}
}

// Add a class to elements where there are no topics / forums
function noContentListing() {
	var noContentText = [
		'This board has no forums.',
		'You do not have the required permissions to view or read topics within this forum.',
		'There are no topics or posts in this forum.',
		'This category has no forums.',
		'No suitable matches were found.'
	];

	var listing = document.querySelectorAll( '.action-bar + .panel .inner' );

	if ( listing && listing.length ) {
		for ( var i = 0; i < listing.length; i++ ) {
			var list = listing[i];

			if ( noContentText.indexOf( list.innerText.trim() ) !== -1 ) {
				list.className += ( checkForClasses( list ) + 'no-content' );
			}
		}
	}
}

// Add class to topics on search results that are ignored
function addSearchIgnoredClass() {
	var postBody = document.querySelectorAll( '.search.post .postbody' );

	if ( postBody && postBody.length ) {
		for ( var i = 0; i < postBody.length; i++ ) {
			var topic = postBody[i];

			if ( topic.innerHTML.indexOf( 'ignore list' ) !== -1 ) {
				topic.className += ( checkForClasses( topic ) + 'ignore' );
			}
		}
	}
}

// Check if there is a new PM (mostly for icon purposes)
function checkForNewPM() {
	var menuItem = document.querySelectorAll( '.cp-menu ul li a[href*="folder"]' );

	if ( menuItem && menuItem.length ) {
		for ( var i = 0; i < menuItem.length; i++ ) {
			var item = menuItem[i];

			if ( item.innerHTML.indexOf( 'strong' ) !== -1 ) {
				item.className += ( checkForClasses( item ) + 'new-pm' );
			}
		}
	}
}

// Check for empty content elements on the page
function checkForEmpty( selector ) {
	var emptySelector = document.querySelectorAll( selector );

	if ( emptySelector && emptySelector.length ) {
		for ( var i = 0; i < emptySelector.length; i++ ) {
			emptySelector[i].parentNode.style.display = 'none';
		}
	}
}

// Generate banner code
function bannerCodeGenerator( bannerImages, bannerCode ) {
	var codeBlock = document.querySelector( bannerCode );

	if ( codeBlock ) {
		// Re-usable variables
		var codeHTML = codeBlock.innerHTML;
		var currentImage = codeHTML.match(/src=\"(.*?)\"/)[1];
		var currentAlt = codeHTML.match(/alt=\"(.*?)\"/)[1];

		// Loop through all banner images and attach onclick event
		var bannerArray = document.querySelectorAll( bannerImages );
		for ( var i = 0; i < bannerArray.length; i++ ) {
			bannerArray[i].onclick = function( e ) {
				changeBannerCode( e, currentImage, currentAlt );
			};
		}

		// Function to change banner code
		function changeBannerCode( e, image, alt ) {
			// Element that has been clicked
			var selector = e.target || e.srcElement;

			// Replace current image src and alt with new element alt and src
			codeBlock.innerHTML = codeHTML.replace( image, selector.getAttribute( 'src' ) ).replace( alt, selector.getAttribute( 'alt' ) );
		}
	}
}

// Add an image wrapper around notification images
function addImageWrapper( selector ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];

			// Create the new image wrapper div
			var imageWrapper = document.createElement( 'div' );
			imageWrapper.setAttribute( 'class', 'image-wrap' );

			// Insert wrapper before the image
			sImage.parentNode.insertBefore( imageWrapper, sImage );

			// Append image to the image wrapper
			imageWrapper.appendChild( sImage );
		}
	}
}

// Check image dimensions and add classes to constrain images in a square space
function checkImageDimensions( selector ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];
			var imageWidth = sImage.clientWidth;
			var imageHeight = sImage.clientHeight;
			var parentWidth = sImage.parentNode.clientWidth;
			var parentHeight = sImage.parentNode.clientHeight;
			var centerThreshold = Math.round( ( imageWidth / parentWidth ) * 100 ); // Determine when images should be centered

			if ( parentHeight > imageHeight ) {
				sImage.className += ( checkForClasses( sImage ) + 'image-fit-height' );
			} else {
				if ( imageWidth != imageHeight ) {
					sImage.className += ( checkForClasses( sImage ) + 'image-fit-width' );
					if ( centerThreshold >= 90 ) {
						sImage.className += ( checkForClasses( sImage ) + 'image-centered' );
					}
				}
			}
		}
	}
}

// Add background image for responsive banners
function addImageBackground( selector, respondDimensions ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];
			var sImageSrc = sImage.getAttribute( 'src' );
			var sImageDimensions = sImageSrc.match( /(\d+x\d+)/g );
			var sImageExt = sImageSrc.match( /.(jpg|jpeg|gif|png)/g );

			// Create responsive background image src
			var responsiveImage = sImageSrc;
			if ( sImageDimensions ) {
				responsiveImage = sImageSrc.replace( sImageDimensions, respondDimensions );
			} else if ( sImageExt ) {
				responsiveImage = sImageSrc.replace( sImageExt, '-' + respondDimensions + sImageExt );
			}

			// Set background image attribute
			sImage.parentNode.setAttribute( 'style', 'background-image: url(' + responsiveImage + ');' );
		}
	}
}

// Detect if on iPhone device
function detectiPhone() {
	if ( navigator.userAgent.match( /iPhone|iPad|iPod/i ) ) {
		body.className += ( checkForClasses( body ) + 'ios' );
	}
}
