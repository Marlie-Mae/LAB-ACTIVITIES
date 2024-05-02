import javax.imageio.ImageIO;
import javax.swing.*;
import javax.swing.table.*;
import java.awt.*;
import java.awt.event.*;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class OrderPage extends JFrame {
    private List<JTable> tables;
    private List<DefaultTableModel> models;
    private JTextArea selectedItemsArea;

    public OrderPage(String name, String address, String contact, String remarks) {
        initComponents(name, address, contact, remarks);
    }

    private void initComponents(String name, String address, String contact, String remarks) {
        setTitle("Order Page");
        setDefaultCloseOperation(WindowConstants.DISPOSE_ON_CLOSE);
        setSize(660, 550);
        getContentPane().setBackground(Color.WHITE);

        setLayout(new GridBagLayout());

        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        JLabel nameLabel = new JLabel("Customer's Name: " + name);
        constraints.gridx = 0;
        constraints.gridy = 0;
        constraints.gridwidth = 1;
        add(nameLabel, constraints);

        JLabel addressLabel = new JLabel("Address: " + address);
        constraints.gridy = 1;
        add(addressLabel, constraints);

        JLabel contactLabel = new JLabel("Contact No.: " + contact);
        constraints.gridy = 2;
        add(contactLabel, constraints);

        JLabel remarksLabel = new JLabel("Remarks: " + remarks);
        constraints.gridy = 3;
        add(remarksLabel, constraints);

        tables = new ArrayList<>();
        models = new ArrayList<>();

        JTabbedPane tabbedPane = new JTabbedPane();
        tabbedPane.addTab("Iced Coffee", createTablePanel("Iced Coffee"));
        tabbedPane.addTab("Frappe", createTablePanel("Frappe"));
        tabbedPane.addTab("Espresso", createTablePanel("Espresso"));
        tabbedPane.addTab("Latte", createTablePanel("Latte"));
        tabbedPane.addTab("Cappuccino", createTablePanel("Cappuccino"));
        constraints.gridx = 0;
        constraints.gridy = 7;
        constraints.gridwidth = 2;
        add(tabbedPane, constraints);
        
        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(130, 130, Image.SCALE_SMOOTH);
            BufferedImage roundedLogoImage = new BufferedImage(130, 130, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = roundedLogoImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 130, 130));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(roundedLogoImage);
            JLabel logoLabel = new JLabel(logoIcon);
            constraints.gridx = 2;
            constraints.gridy = 0;
            add(logoLabel, constraints);
        } catch (IOException ex) {
            ex.printStackTrace();
        }

        selectedItemsArea = new JTextArea(2, 2);
        selectedItemsArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(selectedItemsArea);
        constraints.gridy = 8;
        constraints.gridx = 0;
        constraints.gridy = 20;
        add(scrollPane, constraints);
        selectedItemsArea.setVisible(false);
        scrollPane.setVisible(false);

        JButton addButton = new JButton("Add");
        addButton.setPreferredSize(new Dimension(100, 35));
        addButton.setFont(addButton.getFont().deriveFont(Font.BOLD, 15));
        addButton.setBackground(new Color(92, 64, 51));
        addButton.setForeground(Color.WHITE);
        addButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                int confirmation = JOptionPane.showConfirmDialog(OrderPage.this, "Do you want to continue?", "Confirmation", JOptionPane.YES_NO_OPTION);
                if (confirmation == JOptionPane.YES_OPTION) {
                    Object[][] orderData = getOrderData();
                    displaySelectedRows(orderData);
                    OrderSummaryPage orderSummaryPage = new OrderSummaryPage(name, address, contact, remarks, orderData);
                    orderSummaryPage.setVisible(true);
                    dispose();
                }
            }
        });

        constraints.gridy++;
        constraints.gridx = 2;
        constraints.gridy = 11;
        constraints.anchor = GridBagConstraints.CENTER;
        add(addButton, constraints);

        setVisible(true);
    }

    private JPanel createTablePanel(String type) {
        JPanel panel = new JPanel(new BorderLayout());

        String[] columnNames;
        Object[][] data;

        if (type.equals("Iced Coffee")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Iced Coffee, Cold, Small", "Php25.00", ""},
                    {false, "Iced Coffee, Cold, Medium", "Php50.00", ""},
                    {false, "Iced Coffee, Cold, Large", "Php75.00", ""},
            };
        } else if (type.equals("Frappe")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Frappe, Hot, Small", "Php60.00", ""},
                    {false, "Frappe, Hot, Medium", "Php80.00", ""},
                    {false, "Frappe, Hot, Large", "Php100.00", ""},
            };
        } else if (type.equals("Espresso")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Espresso, Hot, Small", "Php40.00", ""},
                    {false, "Espresso, Hot, Medium", "Php60.00", ""},
                    {false, "Espresso, Hot, Large", "Php90.00", ""},
            };
        } else if (type.equals("Latte")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Latte, Hot, Small", "Php80.00", ""},
                    {false, "Latte, Hot, Medium", "Php100.00", ""},
                    {false, "Latte, Hot, Large", "Php120.00", ""},
            };
        } else if (type.equals("Cappuccino")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Cappuccino, Hot, Small", "Php70.00", ""},
                    {false, "Cappuccino, Hot, Medium", "PhpP90.00", ""},
                    {false, "Cappuccino, Hot, Large", "Php110.00", ""},
            };
        } else {
            // Default data
            columnNames = new String[]{"Choose Order", "Prices", "Quantity"};
            data = new Object[][]{{"", "", ""}};
        }

        DefaultTableModel model = new DefaultTableModel(data, columnNames) {
            @Override
            public Class<?> getColumnClass(int column) {
                return column == 0 ? Boolean.class : super.getColumnClass(column);
            }
        };

        JTable table = new JTable(model);
        table.getColumnModel().getColumn(3).setCellEditor(new QuantityCellEditor());
        table.setRowHeight(30);

        TableColumn checkBoxColumn = table.getColumnModel().getColumn(0);
        checkBoxColumn.setCellRenderer(table.getDefaultRenderer(Boolean.class));
        checkBoxColumn.setCellEditor(table.getDefaultEditor(Boolean.class));
        checkBoxColumn.setPreferredWidth(100);

        JTableHeader header = table.getTableHeader();
        header.setPreferredSize(new Dimension(header.getWidth(), 30));
        header.setBackground(new Color(92, 64, 51));
        header.setForeground(Color.WHITE);
        header.setFont(new Font(header.getFont().getName(), Font.BOLD, 15));

        JScrollPane scrollPane = new JScrollPane(table);
        scrollPane.setPreferredSize(new Dimension(400, 124));
        panel.add(scrollPane, BorderLayout.CENTER);

        tables.add(table);
        models.add(model);

        return panel;
    }

    private class QuantityCellEditor extends DefaultCellEditor {
        private JTextField textField;

        public QuantityCellEditor() {
            super(new JTextField());
            textField = (JTextField) getComponent();
            textField.setHorizontalAlignment(SwingConstants.RIGHT);
        }

        @Override
        public Component getTableCellEditorComponent(JTable table, Object value, boolean isSelected, int row, int column) {
            textField.setText((value != null) ? value.toString() : "");
            return textField;
        }

        @Override
        public Object getCellEditorValue() {
            return textField.getText();
        }
    }

    private Object[][] getOrderData() {
        List<Object[]> orderDataList = new ArrayList<>();
        for (int i = 0; i < tables.size(); i++) {
            JTable table = tables.get(i);
            DefaultTableModel model = models.get(i);
            for (int row = 0; row < model.getRowCount(); row++) {
                Boolean selected = (Boolean) model.getValueAt(row, 0);
                if (selected != null && selected) {
                    String item = (String) model.getValueAt(row, 1);
                    String price = (String) model.getValueAt(row, 2);
                    String quantity = (String) model.getValueAt(row, 3);
                    orderDataList.add(new Object[]{item, quantity, price});
                }
            }
        }
        return orderDataList.toArray(new Object[0][]);
    }

    private void displaySelectedRows(Object[][] orderData) {
        selectedItemsArea.setText(""); 
        for (Object[] rowData : orderData) {
            for (Object item : rowData) {
                selectedItemsArea.append(item.toString() + " ");
            }
            selectedItemsArea.append("\n");
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            OrderPage orderPage = new OrderPage("No name", "Philippines", "09XX-XXX-XXXX", "No remarks");
        });
    }
}
