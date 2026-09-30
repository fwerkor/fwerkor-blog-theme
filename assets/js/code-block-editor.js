( function( wp ) {
    'use strict';

    const { addFilter } = wp.hooks;
    const { createHigherOrderComponent } = wp.compose;
    const { createElement: el, Fragment, useEffect } = wp.element;
    const { InspectorControls, RichText, useBlockProps } = wp.blockEditor;
    const { PanelBody, SelectControl, TextControl, ToggleControl } = wp.components;
    const { __ } = wp.i18n;
    const config = window.FWERKOR_CODE_EDITOR || {};
    const languages = config.languages || {};

    addFilter(
        'blocks.registerBlockType',
        'fwerkor-blog/code-attributes',
        function( settings, name ) {
            if ( name !== 'core/code' ) return settings;

            return {
                ...settings,
                attributes: {
                    ...settings.attributes,
                    language: {
                        type: 'string',
                        source: 'attribute',
                        selector: 'code',
                        attribute: 'lang',
                    },
                    lineNumbers: {
                        type: 'boolean',
                        default: false,
                    },
                    title: {
                        type: 'string',
                        source: 'attribute',
                        selector: 'pre',
                        attribute: 'title',
                    },
                },
                save: function( props ) {
                    const attributes = props.attributes;
                    const classes = [];
                    if ( attributes.language ) classes.push( 'language-' + attributes.language );
                    if ( attributes.lineNumbers ) classes.push( 'line-numbers' );

                    return el(
                        'pre',
                        useBlockProps.save( {
                            title: attributes.title || undefined,
                        } ),
                        el( RichText.Content, {
                            tagName: 'code',
                            value: attributes.content || '',
                            lang: attributes.language || undefined,
                            className: classes.length ? classes.join( ' ' ) : undefined,
                        } )
                    );
                },
            };
        }
    );

    const withCodeControls = createHigherOrderComponent(
        function( BlockEdit ) {
            return function( props ) {
                useEffect(
                    function() {
                        if (
                            props.name === 'core/code' &&
                            ! props.attributes.language &&
                            config.defaultLanguage
                        ) {
                            props.setAttributes( { language: config.defaultLanguage } );
                        }
                    },
                    [ props.name, props.attributes.language ]
                );

                if ( props.name !== 'core/code' ) return el( BlockEdit, props );

                const options = [
                    { label: __( 'Select code language', 'fwerkor-blog' ), value: '' },
                    ...Object.keys( languages ).map( function( key ) {
                        return { label: languages[ key ], value: key };
                    } ),
                ];

                return el(
                    Fragment,
                    null,
                    el( BlockEdit, props ),
                    el(
                        InspectorControls,
                        null,
                        el(
                            PanelBody,
                            { title: __( 'Code highlighting', 'fwerkor-blog' ), initialOpen: true },
                            el( SelectControl, {
                                label: __( 'Language', 'fwerkor-blog' ),
                                value: props.attributes.language || '',
                                options: options,
                                onChange: function( value ) {
                                    props.setAttributes( { language: value } );
                                },
                            } ),
                            el( ToggleControl, {
                                label: __( 'Show line numbers', 'fwerkor-blog' ),
                                checked: !! props.attributes.lineNumbers,
                                onChange: function( value ) {
                                    props.setAttributes( { lineNumbers: value } );
                                },
                            } ),
                            el( TextControl, {
                                label: __( 'Title or file name', 'fwerkor-blog' ),
                                value: props.attributes.title || '',
                                onChange: function( value ) {
                                    props.setAttributes( { title: value } );
                                },
                            } )
                        )
                    )
                );
            };
        },
        'withFwerkorCodeControls'
    );

    addFilter(
        'editor.BlockEdit',
        'fwerkor-blog/code-controls',
        withCodeControls
    );
} )( window.wp );
