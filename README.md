# 8fold Abbreviations for CommonMark

This library is an extension of the [CommonMark parser](https://github.com/thephpleague/commonmark) from the PHP League that adds abbreviation syntax and rendering to Markdown.

This text is written using the syntax to be used to test the validity of the extension; therefore, it will most likely not render as intended.

## The syntax

Similar to the link format: \[](). Only preceded by a tilde and one empty space: ~\[]()

The syntax is inspired by a [conversation on the CommonMark site](https://talk.commonmark.org/t/abbreviations-and-acronyms/890) and other implementations.

When it came to deciding between find-and-replace (or replace all) versus inline - inline was selected.

Inline gives the author more fine-grain control over what becomes an ~[abbr](abbreviation) and what doesn't. This also reduces complexity for the implementation and solves the concern of only defining first use as recommended by [the ~[US](United States) Plain Language Guidelines](https://plainlanguage.gov/resources/articles/keep-it-jargon-free/) and similar guides.

The consensus in the discussion seemed to fall on using the link syntax: \[](). Which is also used with an exclamation mark prefix for images: \!\[](). It is also similar to the syntax used for footnotes: [^]:. Essentially, in cases where two subparts are to be combined, one subpart is wrapped in square brackets while the second subpart is wrapped in ~[parens](parentheses) or otherwise separated from the square brackets.

Given the common usage of the ~[abbr](abbreviation) ~[HTML](Hypertext Markup Language) element, the link syntax makes sense. With that said, there didn't seem to be a consensus around the starting glyph. Common implementations seem to use the asterisk; however, this doesn't seem like the best choice, for reasons also brought up in the discussion thread. Beyond those, I will only add that the asterisk, used in this context, doesn't seem to be natural or communicative device - more one of convenience - consider the caret used for the footnote.

As such, I decided to go with the tilde - because math and what abbreviations and acronyms represent - namely, a symbol that needs to be unpacked to gain full understanding.

In algebra, the tilde signifies approximation. In ~[CSS](Cascading Stylesheets) the "~=" selector signifies the hope that the string on the left will be a part of the string on the right, which is what abbreviations and acronyms tend to represent. So, it's "kind of" this thing - I can almost picture someone putting their hand out palm down rotating back-and-forth to say, "maybe" while kind of drawing a tilde in the air.

I don't believe abbreviations are in any of the popular Markdown specifications and implemented only in Markdown parsers; therefore, this is my humble nod and submission to the problem.
