Lab register files for classes in the Computer Science and Engineering
Department

Use this project to create PDF lab register files for your labs.

# Requirements

You need LaTeX and GNU Make on your system to be able to compile the
`.tex` files and get the PDF output files.

On a Debian-based system you need the following packages:

* texlive-latex-base
* texlive-latex-recommended
* texlive-latex-extra
* make

# Running

In order to build the PDF files you may run:

```
make
```

or you can pass the class name (small letters) to the `make` command to
generate only the PDF lab register file for that class:

```
make so.pdf
make osp.pdf
```

# Tuning

Currently for most files the default configuration is to use `15` rows
for each table, to print two tables per page and use a `1.5` spacing for
each row. This is stated in the first line in every `.tex` file:

```
\documentclass[uso,twosetsperpage,rowstretch=1.5,numrows=15]{register}
```

In the first line the properties for the LaTeX `register` class are
defined, namely:

* `uso`: compiling the file for the `uso` lab
* `twosetsperpage`: placing two tables per page; if this option is
  missing then only one table is used per page
* `rowstretch=1.5`: use `1.5` line spacing per row; in case this option
  is missing or not initialized to anything the default value is `1.25`
* `numrows=15`: use `15` rows per table; in case this option
  is missing or not initialized to anything the default value is `15`
  (this means this option could be missing and it would still use `15`
  rows per table)

In case you need more than `15` rows you may update the `numrows`
option. However, since it's likely that table would get to big and
overlap each other, you would either need to reduce the value for the
`rowstretch` variable (to `1` or `1.2` or `1.25`, for example) or use a
single page. To use a single page you would remove the `twosetsperpage`
option.

## Examples

The `generic-15` uses two tables of `15` rows with a `1.5` row spacing.
The `generic-20.tex` file uses two tables of `20` rows with a `1.2` row
spacing. The `generic-30.tex` file uses a single table of `30` rows with
a `1.5` row spacing.

These files are generic lab registers you can use for a new class, in
case you have no logo available.

# Adding a New Class

If you want to create a lab register file for another lab class, follow
the steps below:

1. Add an class logo image file (PNG or, ideally, PDF) in the `sty/img/`
subfolder using the class name as the filename.

2. Add an entry in the `sty/register.cls` file for the logo image file,
following the existing entries, such as:

```
\DeclareOption{uso}{
  \def\@course{Utilizarea Sistemelor de Operare}
  \def\@courselogo{img/uso}
  \def\@courselogoscale{0.08}
}
```

3. Create a new `.tex` file using the class name as a file name. Simply
copy an existing `.tex` file. Then edit the file. In the first line of
the `.tex` file, similar to the line below:

```
\documentclass[uso,twosetsperpage,rowstretch=1.5,numrows=15]{register}
```

replace `uso` with the class name and update the class options if
required, as discussed in the Tuning section above.

4. Edit the `Makefile` file and the class name to the values of the
`BASENAMES` variable.

5. Compile out the PDF file using:

```
make <class-name>.pdf
```

where `<class-name>` is the name of the class.

6. Open the `<class-name>.pdf` file and see if it looks OK. It may be
that the logo image is too large or too small. If that is the case, edit
the `sty/register.cls` file and update the `@courselogoscale` variable
for your class.

# Support and Contributions

In case of problems, you may contact me directly (razvan.deaconescu
at cs.pub.ro) or you can open an issue on
[GitHub](https://github.com/systems-cs-pub-ro/lab-infrastructure).

In case you want to contribute and make updates, you can follow the
[GitHub workflow](https://guides.github.com/introduction/flow/). Please
fork the [GitHub
repository](https://github.com/systems-cs-pub-ro/lab-infrastructure)
make updates and create a [pull
request](https://help.github.com/articles/using-pull-requests/).
