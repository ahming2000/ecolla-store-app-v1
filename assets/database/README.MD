# MVC Model v0.3.2-alpha (Created by AhMing)

Changing Log:

v0.4.0-alpha (Planned)
- Use `dbSelectRowAttribute()` to replace `dbSelectAll()`and `dbSelectRow()`, and rename to `dbSelectRow()` (2D array data selector).
- Use `dbSelectColumnAttribute()` to replace `dbSelectColumn()` and rename to `dbSelectColumn()` (1D array data Selector).
- `dbSelectCount()` (counting selector) and `dbSelectAttribute()` (single data selector) will remain unchanged.

v0.3.2-alpha
- Fix `dbUpdate()` cannot set null value problem

v0.3.1-alpha
- Fix float value searching problem.
- Multiple attribute select added for `dbSelectRowAttribute()`
- `log()` added.
- Error on `dbUpdate()` fixed.
- Add warn logging if more than 1 row found with `dbSelectAttribute()`
- Residual code at `dbSelectAttribute()` removed.
- Multiple search flag error fixed at `dbSelectCount()`.

v0.3.0-alpha
- Range selection now combine with the normal range function.
- Attribute Count function now combine with normal count function.
- Joined table removed from this version and use `dbQuery()` instead
- `handleException()` added.
- `concatStrChar()` renamed to `concatString()` and add one more features which can concat the array
- Database table information now will read from `db-tables-config.json` for database inserting
- Comment added for documentation.
- Code optimize by using php pre-defined function.

v0.2.1-alpha
- Minor improvement in dbInsert.

v0.2.0-alpha
- Column and row select function now divide into with WHERE CLAUSE and with attrToSelect or both.
- Range function added for preview.
- Joined table preview function added.

v0.1.2-alpha
- Multiple Search function now combine with the single search function, it will auto detect array.

v0.1.1-alpha
- Select column function may cause error when null value (not found) is selected, respond on null value with return false to ignore the error.

v0.1.0-alpha
- Now you can insert table with one function, less confusion on inserting table.
- Multiple function combined with dynamic table selection.

v0.0.0-alpha
- Initial release of Model with multiple specific table function.
