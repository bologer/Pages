# Pages 

## Goal 
You may say that this is yet another documentation generation project. Yes it is, but it is much simpler and 
lightweight then what you've seen before.

I find it very frustrating to have so many versions of tools to build great documentation, but all of them are 
difficult to use, SaaS projects, lack functionallity, etc. 

What do we care the most when we write documentation? 

- you want it to be easily readable
- you want to have code highlighting
- you want it to looks good (visually)

Alright, writing is already hard, but why do you have to care about the rest?

So I decided to create this project to simplify the process of writing documentation. So developer, can focus on 
writing good documentation and this tool to do the rest. 

The idea is that you use this as a library, configure it to you needs and use a CLI tool to build documentation. 

You can easily pack generated content and put it to public domain. 

## Documentation Folder

Your source directory is where you write your documentation.

You can put as many file as you would like and in whatever order. 

> Notice, if you would like to have specific ordering, please ready "Hierarchy" section for details.

At this point of time, library supports only Markdown files (`.md` extension). 

## Hierarchy

The main idea is that you need to prefix your files to ensure correct ordering. 

The prefix can be anything, you can prefix it as `1.` or `1-` or `1.1.1`.

Let's see the following example: 
```
2. intro.md
1. other-file.md
```

The list of files above would produce the following order:

```
1. other-file.html
2. intro.html
```

Notice how `other-file.md` moved to the top of the list as it had `1.` which is smaller then `2.`.

## Page Details

The library is reading your documentation file by file. 

It is using first match of `#` (equivalent to `h1` in HTML) as the page title. 

Consider the following example of file `intro.md`: 


```
# My Page Title
This is regular text

## Subtitle
...
```

If you open `intro.html` you would see `My Page Title` as `<title>` of the page.
