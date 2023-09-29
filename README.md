# Reddit Background Fetcher (Alfred Workflow & Cron Script)

Alfred workflow that fetches desktop backgrounds from subreddits. I wrote this script years ago, but never thought to post it to GitHub. I may revisit this script and convert the PHP to Python at a future date.

The script uses the Reddit's JSON API (yes—it still works) to download images based on the options set by the user. To avoid downloading the same image twice, the unique file name of each image is stored in a file called `cache.txt`, which is checked before an image is downloaded. Each instance that the script successfully runs will also log the timestamp to the file `log.txt`.

For the most optimal workflow, set your Wallpaper directory to where the images download and set to randomly Auto-Rotate.

**Developer note**: Usually I would not commit `.png` images to a repository, but I am doing it here for a pleasent experience with `icon.png` in the Alfred prompt.

## With Alfred

### Installation

- Download repository.
- Go to Alfred preferences.
- Click on _Workflows_.
- Create a new blank workflow.
- Right-click workflow; select _Open in Finder_.
- Place files from downloaded repository into the opened directory.

### Usage

- Trigger the Alfred prompt (`CMD + Space` _by default_)
- Type `bg` to reveal `Fetch backgrounds` and `Clear cache`.
  - `Fetch backgrounds` will run the script and download backgrounds based on your options.
  - `Clear cache` will, believe it or not, clear the cache of previously downloaded file names.

### Configuration

- Go to Alfred preferences.
- Click on the _Reddit Background Fetcher_ workflow.
- Double-click on the _Run Script_ node (to the right of the _bg_ keyword).
- Refer to the _Options_ section below for a description of each option.

## Without Alfred (Cron)

### Installation

- Download repository.
- Place the downloaded repository folder somewhere that you can reference.
  - _Example_: `~/Documents/fetcher`.
- Open `bg-cron.php` in a text editor to change the script options; refer to the _Options_ section below for a description of each option.
- Open _Terminal.app_.
- Type `crontab -e`.
- Enter when you would like the script to run, followed by the path to the file `bg-cron.php` in the respository folder.
  - For `crontab` references, visit [Crontab Guru](https://crontab.guru/)
  - _Example_: `0 5 * * * ~/Documents/fetcher/bg-cron.php` would run the script every day at 5AM.

### Configuration

- Go to Alfred preferences.
- Click on the _Reddit Background Fetcher_ workflow.
- Double-click on the _Run Script_ node (to the right of the _bg_ keyword).
- Refer to the _Options_ section below for a description of each option.

## Options

- `$subreddit` - name of the subreddit you'd like to scrape. (_Default: EarthPorn_)
- `$type` - sort option for subreddit. [hot|new|top|rising] (_Default: top_)
- `$range` - range of time for new search results. [hour|day|week|month|year|all] (_Default: day_)
- `$save_path` - where the images should be saved. (_Default: Documents/Backgrounds/_)
- `$min_bg_width` - minimum width an image should have to avoid stretching. (_Default: 3000_)
