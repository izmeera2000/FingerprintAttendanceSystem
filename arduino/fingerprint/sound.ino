void playSound(int order, int vol) {
  player.volume(vol);
  player.playMp3Folder(order, 1);
}