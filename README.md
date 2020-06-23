# 8fold Abbreviations for CommonMark

This library is an extension for the [CommonMark parser](https://github.com/thephpleague/commonmark) from the PHP League adding abbreviation syntax and rendering to Markdown.

This text is written using that syntax enabling extension testing; therefore, it will most likely not render as intended without a rendering extension using this syntax.

## The syntax

Inspired by the link syntax - `[]()` - and the footnote syntax in the extension from MultiMarkdown - `[^]`.

The syntax is a square bracket followed by a period or dot: `[.]()`.

Just like the footnote indcates superscript, the abbreviation syntax was found to indicate shortening to more people than previously proposed options. Placing the dot inside the opening square bracket allows the abbreviation to exist next to other glyphs as opposed to forcing empty space. (A conversation in the [CommonMark [.Spec](Specification) board](https://talk.commonmark.org/t/abbreviations-and-acronyms/890) was also referenced, and informative)

Given the traditional use of the `abbr` tag commonly combined with the `title` attribute, the link syntax makes sense as the `a` tag combines inner text with `href` and the `img` tag uses two attributes, `src` and `alt` to be valid and accessible.

## Replace-all [.vs.](versus) inline

We decided to go with inline, single instance over footer, replace-all.

Two main options exist for implementing this capability.

The first is to place the abbreviation and definition at the bottom of the document and render all occurences of the abbreviation with the `abbr` element and title. The drawback here is possible impact to readers using [.AT](Assistive Technology) like screen readers; potentially being read the full abbreviation each time.

The second option is to have the abbreviation be inline with the surrounding text. The drawback here is the need to write more each time an author uses the abbreviation.

This library looks at Markdown as being a way of writing potentially rich-text documents first, which can be transformed into [.HTML](Hypertext Markup Language) or something else. The recomendation from the [[.US](United States) Plain Language Guidelines](https://plainlanguage.gov/resources/articles/keep-it-jargon-free/) is to avoid abbreviations and acronyms in general and specifically to:

- Try to keep them to a maximum of two a page.
- Use them if spelling them out would annoy your readers.
- If you must use an abbreviation or acronym, spell it out the first time you use it. For example: [.CBT](Computer-based training).

As a document editor and author, I tend to recommend defining "first use" as "first use per section," where "section" is further defined as beginning with a header; so, if writing a 20 page document and an abbreviation is defined on page one, it's poor [.UX](user experience) to require a reader on page 20 to turn back to page one to jog their memory of the abbreviation's definition. This also speaks to the definitions being at the end of the document, similar to a glossary.
